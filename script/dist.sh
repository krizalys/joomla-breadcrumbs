#!/bin/sh

OUTPUTDIR="/tmp"
DIR="../joomla/mod_krizalys_breadcrumbs"
random="$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)"
workdir="${OUTPUTDIR}/${random}"
mkdir "${workdir}"
cp -r "${DIR}" "${workdir}"

if [ -f ${OUTPUTDIR}/mod_krizalys_breadcrumbs.zip ]; then
    rm -f ${OUTPUTDIR}/mod_krizalys_breadcrumbs.zip
fi

wd="$(pwd)"; cd "${workdir}/mod_krizalys_breadcrumbs"; zip -r ${OUTPUTDIR}/mod_krizalys_breadcrumbs *; cd "${wd}"
rm -rf "${workdir}"
