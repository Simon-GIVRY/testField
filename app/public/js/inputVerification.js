let username = document.querySelector("#username")
let email = document.querySelector("#email")
let password = document.querySelector("#password")
let passwordConfirmation = document.querySelector("#confirmPassword")
let submitButton = document.querySelector("#submit")
let formEl = document.querySelector("form")

let inputs = document.querySelectorAll("input")

let passwordDiv = document.querySelector(".passwordDiv")

let passwordCondition = document.createElement("div")
passwordCondition.classList.add("passwordConditions")

passwordCondition.innerHTML =
`
<p><span class="singleCondition lenght crossed">X</span>Password longer than 8 characters</p>
<p><span class="singleCondition uppercase crossed">X</span>Must contain at least 1 uppercase letter</p>
<p><span class="singleCondition number crossed">X</span>Must contain at least 1 number</p>
<p><span class="singleCondition specialChar crossed">X</span>Must contain at least 1 special character</p>
`


let usernameIsSet = false
let emailIsSet = false
let passwordIsSet = false
let confirmPasswordIsSet = false





//password focus event
password.addEventListener("focus", e=>{

    if (!document.querySelector(".passwordConditions")) {
        passwordDiv.appendChild(passwordCondition)
    }
})

password.addEventListener("focusout", e=>{

    if (document.querySelector(".passwordConditions")) {
        // passwordCondition.remove()
    }
})



// confirmpassword 
let confirmPasswordDiv = document.querySelector(".confirmationPassword")

let confirmPasswordP = document.createElement("p")
confirmPasswordP.innerHTML= `<span class="confirmSpan crossed">X</span>Passwords do not match`

passwordConfirmation.addEventListener("focus", e=>{

    confirmPasswordDiv.appendChild(confirmPasswordP)
    
})


//input events
inputs.forEach(element => {

    element.addEventListener("input", e=>{

        if (e.target === username) {

            let usernameInput =e.target.value

            for (const input of usernameInput) {
                
                if (!input.match(/[A-Za-z0-9_]/gm)) {

                }

            }
        }

        if (e.target === email) {
            let emailInput =e.target.value
            


            if (!emailInput.match(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+[.]+[A-Za-z]+$/)) {
            }


        }

        if (e.target === password) {
            let length = false
            let uppercase = false
            let number = false
            let specialChar = false
            
            let passwordInput = e.target.value

            let lenghtSpan = document.querySelector(".lenght")
            let uppercaseSpan = document.querySelector(".uppercase")
            let numberSpan = document.querySelector(".number")
            let specialCharSpan = document.querySelector(".specialChar")

            if (passwordInput.length >= 7) {
                length = true
                lenghtSpan.innerHTML = `&#10003;`
                lenghtSpan.classList.remove("crossed")
                lenghtSpan.classList.add("checked")

                
            }
            else{
                lenghtSpan.innerHTML = `X`
                lenghtSpan.classList.remove("checked")
                lenghtSpan.classList.add("crossed")
            }

            if (passwordInput.search(/[A-Z]/) > -1 ) {
                uppercase = true

                uppercaseSpan.innerHTML = `&#10003;`
                uppercaseSpan.classList.remove("crossed")
                uppercaseSpan.classList.add("checked")
            }
            else{
                uppercaseSpan.innerHTML = `X`
                uppercaseSpan.classList.remove("checked")
                uppercaseSpan.classList.add("crossed")

            }


            if (passwordInput.search(/[0-9]/) > -1 ) {
                number = true

                numberSpan.innerHTML = `&#10003;`
                numberSpan.classList.remove("crossed")
                numberSpan.classList.add("checked")
            }
            else{
                numberSpan.innerHTML = `X`
                numberSpan.classList.remove("checked")
                numberSpan.classList.add("crossed")

            }

            if (passwordInput.search(/[^A-Za-z0-9]/) > -1 ) {
                specialChar = true

                specialCharSpan.innerHTML = `&#10003;`
                specialCharSpan.classList.remove("crossed")
                specialCharSpan.classList.add("checked")
                
            }
            else{
                specialCharSpan.innerHTML = `X`
                specialCharSpan.classList.remove("checked")
                specialCharSpan.classList.add("crossed")

            }

            if (length === true && uppercase === true && number === true && specialChar === true) {

               
            }
            
            
        }
        if (e.target === passwordConfirmation) {
            let confirmPasswordInput = e.target.value

            if (confirmPasswordInput === password.value) {


                confirmPasswordP.innerHTML = `<span class="confirmSpan checked">&#10003;</span>Passwords are matching`
            }
            else{
                confirmPasswordP.innerHTML = `<span class="confirmSpan crossed">X</span>Passwords do not match`


            }
            
            
        }



    })
    
});




// formEl.addEventListener("submit", e=>{
//     e.preventDefault()
//     console.log("submit");


//     if (!usernameIsSet) {
        
        
//     }


// })


