#!/usr/bin/env sh
coffee -c $* *.coffee

echo 'intdoc' > README.md
echo '======' >> README.md
echo '' >> README.md
echo 'Interactive documentation for JavaScript' >> README.md
echo '' >> README.md
coffee -e 'intdoc=require(".");console.log(intdoc(intdoc).doc);' >> README.md
