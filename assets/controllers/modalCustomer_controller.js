import {Controller} from '@hotwired/stimulus';
import 'bootstrap/dist/js/bootstrap.min.js'

export default class extends Controller {
    connect() {
        let currentId = ''
        let name = ''
        let phone = ''
        let email = ''
        let address = ''
        let zipcode = ''
        let city = ''

        const modalContentShow = document.getElementById("modal-content-show");
        const pName = document.createElement('p');
        const pPhone = document.createElement('p');
        const pEmail = document.createElement('p');
        const pAddress = document.createElement('p');
        const pZipcode = document.createElement('p');
        const pCity = document.createElement('p');
        document.querySelectorAll('.open-modal-show').forEach(button => {
            button.addEventListener('click', function () {
                name = this.getAttribute('data-name');
                phone = this.getAttribute('data-phone');
                email = this.getAttribute('data-email');
                address = this.getAttribute('data-address');
                zipcode = this.getAttribute('data-zipcode');
                city = this.getAttribute('data-city');
                pName.innerHTML = `Name : ${ name }`;
                pPhone.innerHTML = `Phone : ${ phone }`;
                pEmail.innerHTML = `Email : ${ email }`;
                pAddress.innerHTML = `Address : ${ address }`;
                pZipcode.innerHTML = `Zipcode : ${ zipcode }`;
                pCity.innerHTML = `City : ${ city }`;
                modalContentShow.appendChild(pName);
                modalContentShow.appendChild(pPhone);
                modalContentShow.appendChild(pEmail);
                modalContentShow.appendChild(pAddress);
                modalContentShow.appendChild(pZipcode);
                modalContentShow.appendChild(pCity);
                // modalContentShow.innerHTML = `Name: ${name} Phone: ${phone} Email: ${email} Address:${address} Zipcode: ${zipcode} City: ${city}`;
            })
        })

        const modalContentDelete = document.getElementById("modal-content-delete");
        document.querySelectorAll('.open-modal-delete').forEach(button => {
            button.addEventListener('click', function () {
                currentId = this.getAttribute('data-id');
                name = this.getAttribute('data-name');
                modalContentDelete.innerHTML = `Etes vous sur de vouloir supprimer le client: <strong>${name}</strong>`;
            })
        })

        const buttonDelete = document.getElementById('modalDeleteBtn')
        buttonDelete.addEventListener('click', () => {
            if(currentId){
                fetch(`/customers/${currentId}`, {
                    method: 'DELETE',
                    headers: new Headers({
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    })
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href='/customers'
                        }else {
                            alert(response.message)
                        }
                    })
                    .catch(error => console.log('Erreur:',error))
            }
        })
    }
}
