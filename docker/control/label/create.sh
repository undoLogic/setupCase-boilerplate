#!/bin/sh

# use this website
# https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

#rm pdf.pdf
#sleep 1
# we need margins here to calibrate for each printer
wkhtmltopdf --page-width 102 --page-height 58 label.html pdf3.pdf