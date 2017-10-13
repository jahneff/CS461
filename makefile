TARGET=problem_statement
HTML=main_html
SRC={problem_statement}

latex: problem_statement.tex
	latex problem_statement.tex
	dvips -R -Poutline -t letter problem_statement.dvi -o problem_statement.ps
	ps2pdf problem_statement.ps

clean: 
	rm problem_statement.ps
	rm problem_statement.aux
	rm problem_statement.dvi
	rm problem_statement.log

