#!/usr/bin/env bash

set -euo pipefail

TITLE_PREFIX=${TITLE_PREFIX:-"Php-Wasm"}

TEMPLATE_DIR=${TEMPLATE_DIR:-"./source"}
STATIC_DIR=${STATIC_DIR:-"./static"}
PAGES_DIR=${PAGES_DIR:-"./pages"}

OUTPUT_DIR=${OUTPUT_DIR:-"./docs"}

PHP=${PHP:-"php -d display_errors=stderr"}
PANDOC=${PANDOC:-"pandoc"}
YQ=${YQ:-"yq"}

if [! command -v ${PHP} >/dev/null 2>&1]; then
    echo "php is required."
    exit 1
fi

if [! command -v ${YQ} >/dev/null 2>&1]; then
    echo "yq is required."
    exit 1
fi

if [! command -v ${PANDOC} >/dev/null 2>&1]; then
    echo "pandoc is required."
    exit 1
fi

# HIGHLIGHT_STYLE=
# HIGHLIGHT_STYLE=pygments;
# HIGHLIGHT_STYLE=tango;
# HIGHLIGHT_STYLE=espresso;
HIGHLIGHT_STYLE=zenburn;
# HIGHLIGHT_STYLE=kate;
# HIGHLIGHT_STYLE=monochrome;
# HIGHLIGHT_STYLE=breezedark;
# HIGHLIGHT_STYLE=haddock;

if [ "${HIGHLIGHT_STYLE}" != "" ]; then
	HIGHLIGHT_STYLE="--highlight-style ${HIGHLIGHT_STYLE}"
fi

echo -e "\e[33;4mBuilding pages...\e[0m"

find ${PAGES_DIR} -type f | while read PAGE_FILE; do {

	echo -e "\e[37m${PAGE_FILE}...\e[0m"

	DIR=$(dirname ${PAGE_FILE});
	BASE=$(basename ${PAGE_FILE});
	EXT="${BASE##*.}"
	PAGE_NAME="${BASE%.*}"
	DEST=${OUTPUT_DIR}/${DIR#${PAGES_DIR}}/${PAGE_NAME}.html

	if [ "${PAGE_NAME}.${EXT}" == ".fm.yaml" ]; then
		continue;
	fi

	HAS_FM=

	read -r first_line < "${PAGE_FILE}"
    if [[ "$first_line" == "---" ]]; then
		HAS_FM=1
	fi

	# Make sure the matching subdirectory exists
	mkdir -p ${OUTPUT_DIR}/${DIR#${PAGES_DIR}};

	# Determine the template
	if [ "${HAS_FM}" == "1" ]; then
		TEMPLATE=`${YQ} --front-matter=extract '.template' ${PAGE_FILE}`;
	else
		TEMPLATE=${TEMPLATE_DIR}/template.php
	fi

	# Template fallback logic
	if [ "${TEMPLATE}" == "null" ] || [ "${TEMPLATE}" == "" ]; then
		TEMPLATE=${TEMPLATE_DIR}/template.php

		# Check for a .php template for the current file's extension
		if [ -f "${TEMPLATE_DIR}/${EXT}-template.php" ]; then
			TEMPLATE=${TEMPLATE_DIR}/${EXT}-template.php
		fi

		# Check for a .html template for the current file's extension
		if [ -f "source/${EXT}-template.html" ]; then
			TEMPLATE=source/${EXT}-template.html
		fi
	fi

	# Table of contents
	TOC_FLAG=
	if [ "${HAS_FM}" == "1" ]; then
		TOC=`${YQ} --front-matter=extract '.TOC' ${PAGE_FILE}`;
		if [ "${TOC}" == "null" ] || [ "${TOC}" == "" ] || [ "${TOC}" == "true" ]; then
			TOC_FLAG=--toc
		fi
	else
		TOC_FLAG=--toc
	fi

	# Build the final template
	TMP_FILE=`mktemp`
	PAGES_DIR=${PAGES_DIR} ${PHP} ${TEMPLATE} ${PAGE_FILE} > ${TMP_FILE};

	# Build the HTML
	${PANDOC} --data-dir=. -s -f markdown -t html \
		${HIGHLIGHT_STYLE} ${TOC_FLAG} \
		--template=${TMP_FILE} \
		-o ${DEST} \
		--title-prefix="${TITLE_PREFIX}" \
		--css "/style.css" \
		--css "/article.css" \
		--css "/pandoc.css" \
		-H "${OUTPUT_DIR}/heading.css" \
		-H "${OUTPUT_DIR}/fonts.css" \
		${PAGE_FILE}

	#Cleanup
	rm ${TMP_FILE}

}; done;

echo -e "\e[33;4mCopying static assets...\e[0m"

cp -rfv ${STATIC_DIR}/* ${OUTPUT_DIR}/;

echo -e "\e[33;4mAssembing sitemap...\e[0m"

${PHP} source/sitemap.php https://php-wasm.seanmorr.is > ${OUTPUT_DIR}/sitemap.xml;
