I=1
ls -S  ${1}|head -200|gshuf|tail -$3| while read file 
do
	new_file=../${1}/${2}/email${I}.html
	touch $new_file
	echo "<html>" >> $new_file
	cat ${1}/${file} >> $new_file
	echo "</html>" >> $new_file
	((I+=1))
done

