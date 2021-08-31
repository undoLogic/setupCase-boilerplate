#!/bin/sh

# use this website
# https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

#rm pdf.pdf
#sleep 1
# we need margins here to calibrate for each printer
wkhtmltopdf --page-width 102 --page-height 58 --margin-top 1 --margin-right 0 --margin-bottom 0 --margin-left 0 label-single.html pdf-single-page.pdf