
	let frmFileOpen = document.getElementById("frmFileOpen");

	const edtFileName = document.getElementById("edtFileName");
	const btnOpen = document.getElementById("btnOpen");


	btnCrip.addEventListener("click", function(){
		sendFetch(1,edtCrip.value,aCrip);
	});

	btnCopy.addEventListener("click",()=>{
		edtDecrip.value = aCrip.innerHTML;
	});


	btnDecrip.addEventListener("click", function(){
		sendFetch(2,edtDecrip.value,aDecrip);
	});

	frmFileOpen.addEventListener("submit", function(event){
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