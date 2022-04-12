
function buscaVin(vin,placa){
    document.fromcosp.vin.value=vin;
    document.fromcosp.placa.value=placa;
    document.fromcosp.submit();
 }
 
 function buscar()
 {
 
     /*
      * Se agrega el elemento de folio en el arreglo
      */
     var elementos= new Array(
         document.getElementById('placa').value,
         document.getElementById('vin').value,
         document.getElementById('nrpv').value,
         document.getElementById('folio').value);
     /*
      * fin cambio Root
      */
     var contador=0,i;
     for(i=0;i<elementos.length;i++)
     {
         if(elementos[i].length>0)
         {
             contador++;
         }
     }
     if(contador!=1)
     {
         if(contador<1){
             $('#txtError').html('No se ha seleccionado ning\u00fan criterio de b\u00fasqueda.');  
             $('#alertasErrores').show();
         }
         else{
             $('#txtError').html('Estimado ciudadano, debe de ingresar s\u00f3lo uno de los siguientes criterios\nde b\u00fasqueda:<ul><li>N\u00famero de placa\n</li><li>N\u00famero de Identificaci\u00f3n Veh\u00edcular (NIV)</li><li>Folio de Constancia de Inscripci\u00f3n (FCI)</li><li>N\u00famero de Constancia de Inscripci\u00f3n (NCI)</li></ul>');  
             $('#alertasErrores').show();
         }
         return;
     }
 
     sendForm();
 }
 
 
 function sendForm(){
 
     if(validate_form(document.forms[0])){
       document.forms[0].submit();
     }else{
   //  toggleDiv('mydiv');
     }
  }
 
 
 function formatea (texto) {
    texto.value = Trim(texto.value.toUpperCase());
 }
 function FormatoNormal (texto) {
    texto.value = Trim(texto.value);
 }
 function LTrim(s){
     // Devuelve una cadena sin los espacios del principio
     var i=0;
     var j=0;
 
     // Busca el primer caracter <> de un espacio
     for(i=0; i<=s.length-1; i++)
         if(s.substring(i,i+1) != ' '){
             j=i;
             break;
         }
     return s.substring(j, s.length);
 }
 function RTrim(s){
     // Quita los espacios en blanco del final de la cadena
     var j=0;
 
     // Busca el ï¿½ltimo caracter <> de un espacio
     for(var i=s.length-1; i>-1; i--)
         if(s.substring(i,i+1) != ' '){
             j=i;
             break;
         }
     return s.substring(0, j+1);
 }
 
 function Trim(s){
     // Quita los espacios del principio y del final
     return LTrim(RTrim(s));
 }
 
 
   function validate_required(form)
   {
 
     /*
      * validaciï¿½n incluyendo el folio constancia
      */
     if((form.nrpv.value==null || form.nrpv.value=="") &&
         (form.vin.value==null || form.vin.value=="") &&
         (form.placa.value==null || form.placa.value=="") &&
         (form.folio.value==null || form.folio.value==""))
     /*
      * fin cambio Root
      */
         {
         // el vin o nrpv son  requerido
         return false;
     }else{
         return true;
     }
   }
 
 
 
 
   function validate_alphanumeric_nrpv(field)
   {
           var numaric = field.value;
           for(var j=0; j<numaric.length; j++)
                   {
                     var alphaa = numaric.charAt(j);
                     var hh = alphaa.charCodeAt(0);
                     if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
                     {
                     }
                   else	{
                            return false;
                     }
                   }
    return true;
   }
 
   function validate_alphanumeric_niv(field)
   {
           var numaric = field.value;
           for(var j=0; j<numaric.length; j++)
                   {
                     var alphaa = numaric.charAt(j);
                     var hh = alphaa.charCodeAt(0);
                     if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123))
                     {
                        // Verificamos para las letras especiales 79:O, 73:I y 81:Q
                        if(hh==79 || hh==73 || hh==81){
                           return false;
                        }
                     }
                   else	{
                            return false;
                     }
                   }
    return true;
   }
   
   // Funciï¿½n para validar que el folio sea numerico
   function validate_numeric_folio(field)
   {
           var numaric = field.value;
           for(var j=0; j<numaric.length; j++)
                   {
                     var alphaa = numaric.charAt(j);
                     var hh = alphaa.charCodeAt(0);
                     if(hh > 47 && hh < 58)
                     {
                     }
                   else	{
                            return false;
                     }
                   }
    return true;
   }
   // termina cambio Root
 
 //<!-- Script by hscripts.com -->
 function validate_vin(field) {
 
      if(field.value!=null && field.value!="") {
        if(validate_alphanumeric_niv(field)) {
           return true;
        } else {
           return false;
        } // end_if
      }else{
         return true;
      }
 
 } // end_mtd_validate_vin
 
 function validate_nrpv(field){
  if(field.value!=null && field.value!=""){
     if(field.value.length!=8){
       // longitud invalida
         return false;
       }else if(!validate_alphanumeric_nrpv(field)){
       // no es alfanumerico
         return false;
       }else{
       //ok
       return true;
     }
  }return true;
 }
 
 /*
  * funciones para validar la longitud y si es numerico el folio
  */
 function validate_folio(field){
     if(field.value!=null && field.value!=""){
         if(field.value.length>8){
             // longitud invalida
             return false;
         }
         if(!validate_numeric_folio(field)){
             // no es Numerico
             return false;
         }
         return true;
     }
     return true;
 
 }
 function isAlphanumeric(val)
 {
     if (val.match(/^[a-zA-Z0-9]+$/))
     {
         return true;
     }
     else
     {
         return false;
     }
 }
 /*
  * fin cambio Root
  */
 
 function validate_form(vform){
   var msg="";
   var isValid=true;
   vform.vin.value=LTrim(RTrim(vform.vin.value.toUpperCase()));
   vform.nrpv.value=LTrim(RTrim(vform.nrpv.value.toUpperCase()));
   vform.placa.value=LTrim(RTrim(vform.placa.value.toUpperCase()));
   // validaciï¿½n del folio
     vform.folio.value=LTrim(RTrim(vform.folio.value.toUpperCase()));
   // fin cambio Root
   if(!validate_required(vform)){
     // se agrega que tambiÃ©n el folio puede capturarse
     msg="Debe capturar un  NIV, NCI, Folio o PLACA ";
     // fin cambio Root
     isValid=false;
   }else{
 
     if(!validate_vin(vform.vin)){
       msg="NIV Invalido (" + vform.vin.value + ")";
       isValid=false;
     }
 
     if(!validate_nrpv(vform.nrpv)){
      if(msg!=""){
          msg=msg+"\n";
      }
      msg=msg+"NCI invalido (" + vform.nrpv.value + ")";
      isValid=false;
     }
         /*
          * validaciï¿½n del folio
          */
         if(!validate_folio(vform.folio)){
             if(msg!=""){
                 msg=msg+"\n";
             }
             msg=msg+"Folio invalido (" + vform.folio.value + ")";
             isValid=false;
         }
         /*
          * fin cambio Root
          */
 
   }
     if(!isValid){
         $('#txtError').html(msg);  
         $('#alertasErrores').show();
      return false;
     }else{
     if(vform.captcha.value==null || vform.captcha.value.length==0){
         $('#txtError').html('Falta escribir el texto de la Imagen');  
         $('#alertasErrores').show();
         $('#captcha').css("border-color","red");
         $('#astcaptcha').css("color","red");
        return false;
     }
     return true;
     }
 
 }
 
   function toggleDiv(divid){
     if(document.getElementById(divid).style.display == 'none'){
       document.getElementById(divid).style.display = 'block';
     }else{
       document.getElementById(divid).style.display = 'none';
     }
   }
 
 
 
 
 function popUp(URL,width,height) {
   day = new Date();
   id = day.getTime();
   eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width="+width+",height="+height+",left = 200,top = 200');");
 }


 document.querySelector('#form12').addEventListener('submit', function(e) {
   e.preventDefault();
   console.log('sofsdnf');
 });