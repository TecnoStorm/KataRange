const aumento = document.querySelector('.aumento1');
const aumento2 = document.querySelector('.aumento2');
const resta = document.querySelector('.resta1');
const resta2 = document.querySelector('.resta2');
const inputNumber = document.querySelector('#nota');
if(inputNumber){
    console.log("funco bien");
}
else{
    console.log("funco mal");
}
aumento.addEventListener('click', () => {
if(!inputNumber.value){
    inputNumber.value=5;
}
else{
    if(inputNumber.value==10){
    }
    else{
        let valor = parseFloat(inputNumber.value); 
        valor = (valor + 0.1).toFixed(1);
        inputNumber.value = valor; 
    }
}
});
aumento2.addEventListener('click', () => {
    if(!inputNumber.value){
        inputNumber.value=5;
    }
    else{
        if(inputNumber.value==10){
        }
        if(!Number.isInteger(inputNumber.value) && inputNumber.value>9){
            suma=10-inputNumber.value;
            let valor = parseFloat(inputNumber.value); 
            valor = (valor + suma);
            inputNumber.value = valor; 
        }
        else{
            let valor = parseFloat(inputNumber.value); 
            valor = (valor + 1);
            inputNumber.value = valor; 
        }
    }
    });
    resta.addEventListener('click', () => {
        if(!inputNumber.value){
            inputNumber.value=5;
        }
        else{
            if(inputNumber.value==5){
            }
            else{
                let valor = parseFloat(inputNumber.value); 
                valor = (valor - 0.1).toFixed(1)
                inputNumber.value = valor; 
            }
        }
        });
        
        
        resta2.addEventListener('click', () => {
            if(!inputNumber.value){
                inputNumber.value=5;
            }
            else{
                if(inputNumber.value==5){
                }
                if(!Number.isInteger(inputNumber.value) && inputNumber.value<6){
                    suma=5-inputNumber.value;
                    let valor = parseFloat(inputNumber.value); 
                    valor = (valor + suma);
                    inputNumber.value = valor; 
                }

                    else{
                    let valor = parseFloat(inputNumber.value); 
                    valor = (valor - 1).toFixed(1)
                    inputNumber.value = valor; 
                }
            }
            });