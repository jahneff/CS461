TARGET=neffjdesigndoc461.tex
SRC={neffjdesigndoc461.tex}

latex: neffjdesigndoc461.tex
	latex neffjdesigndoc461.tex
	dvips -R -Poutline -t letter neffjdesigndoc461.dvi -o neffjdesigndoc461.ps
	ps2pdf neffjdesigndoc461.ps

clean: 
	rm cs461_techreview_neffj.ps
	rm cs461_techreview_neffj.aux
	rm cs461_techreview_neffj.dvi
	rm cs461_techreview_neffj.log

