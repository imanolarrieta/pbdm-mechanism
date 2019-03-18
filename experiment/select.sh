rm -f emails/email_pool/spam/*
rm -f emails/email_pool/ham/*
rm -f emails/email_pool/sel*
rm -f emails/selection/*.txt
touch emails/email_pool/sel_spam.txt
touch emails/email_pool/sel_ham.txt
touch emails/selection/spam.txt
touch emails/selection/ham.txt

ls -S emails/enron1/spam |head -400| tail -300|gshuf| while read file
do
	cp emails/enron1/spam/$file emails/email_pool/spam/$file
	echo $file >> emails/email_pool/sel_spam.txt
done

ls -S emails/enron1/ham |head -400 |tail -300|gshuf| while read file
do
	cp emails/enron1/ham/$file emails/email_pool/ham/$file
	echo $file >> emails/email_pool/sel_ham.txt
done

PHASES=(1 2 4 5 6)
N=(0 ${1} ${2} 0 ${3} ${4} ${5})
echo ${N[*]}
for PHASE in "${PHASES[@]}"
do
	rm -f emails/spam/phase${PHASE}/email*
	rm -f emails/ham/phase${PHASE}/email*
	I=1
	echo ${N[$PHASE]}
	diff emails/selection/spam.txt emails/email_pool/sel_spam.txt | grep '^>' | sed 's/^>\ //'|head -${N[$PHASE]}|while read file 
	do
		new_file=emails/spam/phase${PHASE}/email${I}.html
		touch $new_file
		echo "<html>" >> $new_file
		cat emails/enron1/spam/${file} >> $new_file
		echo "</html>" >> $new_file
		echo $file >> emails/selection/spam.txt
		((I+=1))
	done

	I=1
	diff emails/selection/ham.txt emails/email_pool/sel_ham.txt | grep '^>' | sed 's/^>\ //'|head -${N[$PHASE]} |while read file 
	do
		new_file=emails/ham/phase${PHASE}/email${I}.html
		touch $new_file
		echo "<html>" >> $new_file
		cat emails/enron1/ham/${file} >> $new_file
		echo "</html>" >> $new_file
		echo $file >> emails/selection/ham.txt
		((I+=1))
	done




done



