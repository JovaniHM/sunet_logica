const sendRequest = ( captcha ) => {
    const details = {
        placa: 'PHB6260',
        vin: '',
        folio: '',
        nrpv: '',
        captcha,
        pageSource: 'index.jsp',
    };
    
    let formBody = [];
    for (const property in details) {
      const encodedKey = encodeURIComponent(property);
      const encodedValue = encodeURIComponent(details[property]);
      formBody.push(encodedKey + "=" + encodedValue);
    }
    formBody = formBody.join("&");
    
    const config = {
        method: 'POST',
        redentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow',
        body: formBody,
    }
    
    fetch('http://www2.repuve.gob.mx:8080/ciudadania/servletconsulta', config)
    .then( resp => resp.text() )
    .then( console.log )
}

// sessionStorage.setItem('_gat', '1');
// sessionStorage.setItem('_gid', 'GA1.3.891536131.1638896315');
// sessionStorage.setItem('JSESSIONID', 'gJynhw7ZJyY7JPlm4VN1qpVD5m5jnQPGVwdVQsgRWwSXQhwB9phQ!1662477582');
// sessionStorage.setItem('_ga', 'GA1.3.765527852.1638896315');

document.cookie = "_gat=1; domain=.repuve.gob.mx; path=/;";
document.cookie = "_gid=GA1.3.891536131.1638896315; domain=.repuve.gob.mx; path=/;";
document.cookie = "JSESSIONID=gJynhw7ZJyY7JPlm4VN1qpVD5m5jnQPGVwdVQsgRWwSXQhwB9phQ!1662477582; domain=www2.repuve.gob.mx; path=/;";
document.cookie = "_ga=GA1.3.765527852.1638896315; domain=.repuve.gob.mx; path=/;";