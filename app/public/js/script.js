let elBody = document.querySelector("body")

let voile = document.createElement('div')
voile.classList.add("voile")

let menu = document.createElement('div')
voile.appendChild(menu)
menu.classList.add("menu")
menu.innerHTML=
`
    <menu>
        <li><a href="#">Accueil</a></li>
        <li><a href="#">Produits</a></li>
        <li><a href="#">A Propos</a></li>
        <li><a href="#">Contact</a></li>
    </menu>
`



document.addEventListener("keydown", e=>{
    
    if (e.key === "Escape") {
        
        if (document.querySelector(".voile")) {
            voile.remove()
            
        }
        else{
            elBody.appendChild(voile)

        } 





    
    }


})