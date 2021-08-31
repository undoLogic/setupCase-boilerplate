#!/bin/sh

# use this website
# https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

#rm pdf.pdf
#sleep 1
wkhtmltopdf --page-width 100 --page-height 100 label.html pdf.pdf