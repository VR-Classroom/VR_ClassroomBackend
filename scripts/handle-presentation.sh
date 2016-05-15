#!/bin/bash

echo Running convert on $1
FRESH=${1:0:-4}
NODIR=${FRESH##*/}
end=".jpg"
echo $FRESH$end
echo $NODIRend
mkdir $FRESH
convert $1 $FRESH/p$end
chmod 777 -R $FRESH
#remove old pdf file
rm $1
