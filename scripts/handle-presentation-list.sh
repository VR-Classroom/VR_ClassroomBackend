#!/bin/bash

#echo Running ls on $1
echo $(ls $1)"/"| sed 's/ /\//g'  


