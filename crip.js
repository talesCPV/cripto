
	let frmCrip = document.getElementById("frmCrip");

	const edtCrip = document.getElementById("edtCrip");
	const btnCrip = document.getElementById("btnCrip");
	const aCrip = document.getElementById("aCrip");
	const btnCopy = document.querySelector("#btnCopy");

	const edtDecrip = document.getElementById("edtDecrip");
	const btnDecrip = document.getElementById("btnDecrip");
	const aDecrip = document.getElementById("aDecrip");

	btnCrip.addEventListener("click", function(){
		sendFetch(1,edtCrip.value,aCrip);
	});

	btnCopy.addEventListener("click",()=>{
		edtDecrip.value = aCrip.innerHTML;
	});


	btnDecrip.addEventListener("click", function(){
		sendFetch(2,edtDecrip.value,aDecrip);
	});

	frmCrip.addEventListener("submit", function(event){
		event.preventDefault();
	});

function sendFetch(std,str,obj){

	const data = new URLSearchParams();
	data.append('std', std);
	data.append('str',str);

	const myRequest = new Request('crip.php',
	    {
	        method: 'POST',
	        body: data
	    });

	fetch(myRequest)
	  .then(function(response){

	    response.text().then(function (text) {
	    	obj.innerHTML = text;
		});

	});

}