#!/bin/sh

# use this website
# https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

#rm pdf.pdf
#sleep 1
# we need margins here to calibrate for each printer
wkhtmltopdf --page-width 102 --page-height 58 --margin-top 3 --margin-right 3 --margin-bottom 3 --margin-left 3 label.html pdf4.pdf