#!/usr/bin/env bash

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

if [ "${HIGHLIGHT_STYLE}" != "" ]; then
	HIGHLIGHT_STYLE="--highlight-style ${HIGHLIGHT_STYLE}"
fi

set -eux

php source/template.php > source/template.html;
php source/with-hero.php > source/with-hero.html;

find ./pages -type f | while read FILENAME; do {

	DIR=$(dirname ${FILENAME});
	BASE=$(basename ${FILENAME});
	EXT="${BASE##*.}"
	FILENAME="${BASE%.*}"
	DEST=./docs${DIR#./pages}/${FILENAME}.html

	if [ "${FILENAME}.${EXT}" == ".fm.yaml" ]; then
		continue;
	fi

	mkdir -p ./docs${DIR#./pages};

	TEMPLATE=`yq --front-matter=extract '.template' ${DIR}/${FILENAME}.${EXT} || echo ""`;
	if [ "${TEMPLATE}" == "null" ] || [ "${TEMPLATE}" == "" ]; then
		TEMPLATE=source/template.html
		if [ -f "source/${EXT}-template.html" ]; then
			TEMPLATE=source/${EXT}-template.html
		fi
	fi

	TOC_FLAG=
	TOC=`yq --front-matter=extract '.TOC' ${DIR}/${FILENAME}.${EXT} || echo ""`;
	if [ "${TOC}" == "null" ] || [ "${TOC}" == "" ] || [ "${TOC}" == "true" ]; then
		TOC_FLAG=--toc
	fi

	pandoc --data-dir=. -s -f markdown -t html \
		${HIGHLIGHT_STYLE} ${TOC_FLAG} \
		--template=${TEMPLATE} -o ${DEST} \
		--title-prefix="${TITLE_PREFIX}" \
		--css "/heading.css" \
		--css "/style.css" \
		--css "/article.css" \
		--css "/pandoc.css" \
		--css "/fonts.css" \
		${DIR}/${FILENAME}.${EXT};

}; done;

cp -rfv static/* docs/;

php source/sitemap.php https://php-wasm.seanmorr.is > docs/sitemap.xml;
