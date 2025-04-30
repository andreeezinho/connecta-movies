function readImage(){
    if (this.files && this.files[0]) {
        var file = new FileReader();
        file.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };       
        file.readAsDataURL(this.files[0]);
    }
}

function readBannerImage(){
    if (this.files && this.files[0]) {
        var file = new FileReader();
        file.onload = function(e) {
            document.getElementById("banner-preview").src = e.target.result;
        };       
        file.readAsDataURL(this.files[0]);
    }
}

function readCapaImage(){
    if (this.files && this.files[0]) {
        var file = new FileReader();
        file.onload = function(e) {
            document.getElementById("capa-preview").src = e.target.result;
        };       
        file.readAsDataURL(this.files[0]);
    }
}

async function searchAddress(){
    var cep = document.getElementById("cep").value

    try{
        const response = await fetch("https://viacep.com.br/ws/"+cep+"/json/", {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
              }
        })

        var endereco = await response.json()
    }catch(error){
        console.log("Requisição não encontrada")
    }

    if(endereco != null){
        insertAddressValues(endereco)
    }
}

function insertAddressValues(endereco){
    console.log(endereco)
    document.getElementById("rua").value=(endereco.logradouro) ?? null
    document.getElementById("cidade").value=(endereco.localidade) ?? null
    document.getElementById("estado").value=(endereco.estado) ?? null
}


if(document.getElementById("cpf")){
    function maskCpf(i, max){
        var v = i.value;
    
        if(isNaN(v[v.length-1])){
            i.value = v.substring(0, v.length-1);
        }
    
        i.setAttribute("maxlength", max);
    
        if(v.length == 3 || v.length == 7){
            i.value += ".";
        }
    
        if(v.length == 11){
            i.value += "-";
        }
    }
}

if(document.getElementById("telefone")){
    function maskTel(i, max){
        var v = i.value;
    
        if(isNaN(v[v.length-1])){
            i.value = v.substring(0, v.length-1);
        }
    
        i.setAttribute("maxlength", max);
    
        if(v.length == 2){
            i.value += " ";
        }
    
        if(v.length == 7){
            i.value += "-";
        }
    }
}

if(document.getElementById("icone")){
    document.getElementById("icone").addEventListener("change", readImage, false);
}

if(document.getElementById("banner")){
    document.getElementById("banner").addEventListener("change", readBannerImage, false);
}

if(document.getElementById("imagem")){
    document.getElementById("imagem").addEventListener("change", readCapaImage, false);
}

if(document.getElementById("cep")){
    document.getElementById("cep").addEventListener("blur", searchAddress, false);
}

