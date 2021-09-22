function kurumsalMusteri(){
	var kurumsal = document.getElementById('kurumsal'); 

	var firmaAd = document.getElementById('firmaAd');
	var vergiNo = document.getElementById('vergiNo');
	var vergiDaire = document.getElementById('vergiDaire');

	var kurumsal_var = document.getElementById('kurumsal_var');    

	if(kurumsal.value == 1){
		kurumsal_var.style.display = "none";

		firmaAd.required = false;
		vergiNo.required  = false;
		vergiDaire.required  = false;
		kurumsal.value = 0;
	}else{
		kurumsal_var.style.display = "block";

		firmaAd.required = true;
		vergiNo.required  = true;
		vergiDaire.required  = true;
		kurumsal.value = 1;
	}
} 
var kurumsal = document.getElementById('kurumsal'); 

var firmaAd = document.getElementById('firmaAd');
var vergiNo = document.getElementById('vergiNo');
var vergiDaire = document.getElementById('vergiDaire');

var kurumsal_var = document.getElementById('kurumsal_var');    

if(kurumsal.value == 1){
	kurumsal_var.style.display = "none";

	firmaAd.required = false;
	vergiNo.required  = false;
	vergiDaire.required  = false;
	kurumsal.value = 0;
}else{
	kurumsal_var.style.display = "block";

	firmaAd.required = true;
	vergiNo.required  = true;
	vergiDaire.required  = true;
	kurumsal.value = 1;
} 
