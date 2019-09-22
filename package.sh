#!/bin/sh

VERSION="1.2.0"

cd joomla/mod_krizalys_breadcrumbs; zip -r ../../mod_krizalys_breadcrumbs-${VERSION}-all-languages.zip .; cd ../..
cp mod_krizalys_breadcrumbs-${VERSION}-all-languages.zip mod_krizalys_breadcrumbs-${VERSION}.zip

for locale in de-DE es-ES fr-FR hu-HU it-IT nl-NL; do
    zip -d mod_krizalys_breadcrumbs-${VERSION}.zip \
        language/${locale}/* \
        language/${locale}/

    xml="mod_krizalys_breadcrumbs-${locale}.xml"
    dir="mod_krizalys_breadcrumbs-${VERSION}-${locale}"
    mkdir -p ${dir}/language/${locale}
    cp -R joomla/mod_krizalys_breadcrumbs/language/${locale}/* ${dir}/language/${locale}
    cp joomla/mod_krizalys_breadcrumbs/index.html ${dir}/language
    cp joomla/mod_krizalys_breadcrumbs/index.html ${dir}
    cp joomla/${xml} ${dir}
    cd ${dir}; zip -r ../${dir}.zip .; cd ..
    rm -rf ${dir}
done
