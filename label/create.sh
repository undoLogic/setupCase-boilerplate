#!/bin/sh

# use this website
# https://wkhtmltopdf.org/usage/wkhtmltopdf.txt

rm pdf.pdf
wkhtmltopdf --page-size A4 --margin-left 10 --margin-right 20 label.html pdf.pdf