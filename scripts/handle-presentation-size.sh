#!/bin/bash

#echo Running ls on $1
count=0
for i in $1/*; do  
	let count=count+1
done

echo $count
