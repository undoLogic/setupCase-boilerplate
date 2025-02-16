PDF security policy for imagemagick

nano /etc/ImageMagick-6/policy.xml
nano /etc/ImageMagick-7/policy.xml

<policy domain="coder" rights="none" pattern="PDF" />
change to 
<policy domain="coder" rights="read | write" pattern="PDF" />

dockerfile

imageMagick 6
RUN sed -i 's|<policy domain="coder" rights="none" pattern="PDF" />|<policy domain="coder" rights="read | write" pattern="PDF" />|' /etc/ImageMagick-6/policy.xml

imageMagick 7
RUN sed -i 's|<policy domain="coder" rights="none" pattern="PDF" />|<policy domain="coder" rights="read | write" pattern="PDF" />|' /etc/ImageMagick-7/policy.xml






