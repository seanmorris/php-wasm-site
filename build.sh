#!/usr/bin/env bash

set -euxo pipefail

TITLE_PREFIX=Php-Wasm
HIGHLIGHT_STYLE=

# HIGHLIGHT_STYLE=pygments;
# HIGHLIGHT_STYLE=tango;
# HIGHLIGHT_STYLE=espresso;
HIGHLIGHT_STYLE=zenburn;
# HIGHLIGHT_STYLE=kate;
# HIGHLIGHT_STYLE=monochrome;
# HIGHLIGHT_STYLE=breezedark;
# HIGHLIGHT_STYLE=haddock;

OUTPUT_DIR=./docs
PAGES_DIR=./pages

PHP=${PHP:-"php -d display_errors=stderr"}
PANDOC=${PANDOC:-"pandoc"}
YQ=${YQ:-"yq"}

if ! command -v ${PHP} >/dev/null 2>&1
then
    echo "php is required."
    exit 1
fi

if ! command -v ${YQ} >/dev/null 2>&1
then
    echo "yq is required."
    exit 1
fi

if ! command -v ${PANDOC} >/dev/null 2>&1
then
    echo "pandoc is required."
    exit 1
fi

if [ "${HIGHLIGHT_STYLE}" != "" ]; then
	HIGHLIGHT_STYLE="--highlight-style ${HIGHLIGHT_STYLE}"
fi

echo -e "\e[33;4mBuilding templates...\e[0m"

${PHP} source/template.php > source/template.html;

echo -e "\e[33;4mBuilding pages...\e[0m"

find ${PAGES_DIR} -type f | while read FILENAME; do {

	DIR=$(dirname ${FILENAME});
	BASE=$(basename ${FILENAME});
	EXT="${BASE##*.}"
	FILENAME="${BASE%.*}"
	DEST=${OUTPUT_DIR}/${DIR#${PAGES_DIR}}/${FILENAME}.html

	if [ "${FILENAME}.${EXT}" == ".fm.yaml" ]; then
		continue;
	fi

	mkdir -p ${OUTPUT_DIR}/${DIR#${PAGES_DIR}};

	TEMPLATE=`${YQ} --front-matter=extract '.template' ${DIR}/${FILENAME}.${EXT} || echo ""`;
	if [ "${TEMPLATE}" == "null" ] || [ "${TEMPLATE}" == "" ]; then
		TEMPLATE=source/template.html
		if [ -f "source/${EXT}-template.html" ]; then
			TEMPLATE=source/${EXT}-template.html
		fi
	fi

	TOC_FLAG=
	TOC=`${YQ} --front-matter=extract '.TOC' ${DIR}/${FILENAME}.${EXT} || echo ""`;
	if [ "${TOC}" == "null" ] || [ "${TOC}" == "" ] || [ "${TOC}" == "true" ]; then
		TOC_FLAG=--toc
	fi

	PAGE_FILE=${DIR}/${FILENAME}.${EXT}

	${PHP} ${TEMPLATE} ${PAGE_FILE} > source/tmp.html;

	${PANDOC} --data-dir=. -s -f markdown+yaml_metadata_block -t html \
		${HIGHLIGHT_STYLE} ${TOC_FLAG} \
		--template=source/tmp.html \
		-o ${DEST} \
		--title-prefix="${TITLE_PREFIX}" \
		--css "/style.css" \
		--css "/article.css" \
		--css "/pandoc.css" \
		-H "${OUTPUT_DIR}/heading.css" \
		-H "${OUTPUT_DIR}/fonts.css" \
		${PAGE_FILE}

}; done;

echo -e "\e[33;4mCopying static assets...\e[0m"

cp -rfv static/* ${OUTPUT_DIR}/;

echo -e "\e[33;4mAssembing sitemap...\e[0m"

${PHP} source/sitemap.php https://php-wasm.seanmorr.is > docs/sitemap.xml;
