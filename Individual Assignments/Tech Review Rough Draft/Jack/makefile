TARGET=cs461_techreview_neffj
SRC={cs461_techreview_neffj}

latex: cs461_techreview_neffj.tex
	latex cs461_techreview_neffj.tex
	dvips -R -Poutline -t letter cs461_techreview_neffj.dvi -o cs461_techreview_neffj.ps
	ps2pdf cs461_techreview_neffj.ps

clean: 
	rm cs461_techreview_neffj.ps
	rm cs461_techreview_neffj.aux
	rm cs461_techreview_neffj.dvi
	rm cs461_techreview_neffj.log

