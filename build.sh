#!/usr/bin/env bash

set -eux

php ./source/template.php > source/template.html;

find ./pages -type f | while read FILENAME; do {

	DIR=$(dirname ${FILENAME});
	BASE=$(basename ${FILENAME});
	EXT="${BASE##*.}"
	FILENAME="${BASE%.*}"
	DEST=./docs${DIR#./pages}/${FILENAME}.html

	mkdir -p ./docs${DIR#./pages};

	TEMPLATE=`yq --front-matter=extract '.template' ${DIR}/${FILENAME}.${EXT}`;
	if [ "${TEMPLATE}" == "null" ] || [ "${TEMPLATE}" == "" ]; then
		TEMPLATE=source/template.html
		if [ -f "source/${EXT}-template.html" ]; then
			TEMPLATE=source/${EXT}-template.html
		fi
	fi

	TOC_FLAG=
	TOC=`yq --front-matter=extract '.TOC' ${DIR}/${FILENAME}.${EXT}`;
	if [ "${TOC}" == "null" ] || [ "${TOC}" == "" ] || [ "${TOC}" == "true" ]; then
		TOC_FLAG=--toc
	fi

	pandoc --data-dir=. -s -f markdown -t html \
		--highlight-style zenburn ${TOC_FLAG} \
		--template=${TEMPLATE} -o ${DEST} \
		${DIR}/${FILENAME}.${EXT};

}; done;

cp -rfv static/* docs/;
