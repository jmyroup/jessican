function rowColor() {
	var row,i;
	row = document.getElementsByClassName("colouredrow");
	for(i=0;i<row.length;i++) {
		row[i].style.background = "#9966CC";
	}
}

function rowColorHover() {
	var row2,i;
	row2 = document.getElementsByClassName("colouredrow");
	for(i=0;i<row2.length;i++) {
		row2[i].onmouseover = function() {
			this.style.background = "#339966";
		}
		row2[i].onmouseout = function() {
			this.style.background = "#9966CC";
		}
	}
}
		
if(document.getElementById && document.createTextNode) {
	window.onload = function() {
		rowColor();
		rowColorHover();
	}
}
