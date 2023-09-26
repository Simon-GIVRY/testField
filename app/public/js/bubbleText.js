let body = document.querySelector("body")

let bubble = document.createElement("div")
bubble.classList.add("bubble")

bubble.innerHTML=
`
<div class="close">
<p>X</p>
</div>
<div class="text">
<p>To open the menu and access to other pages press the "Escape" key</p>
</div>
<div class="progressbar"></div>
`





window.addEventListener("load", e=>{
    let time = 0%
    
    body.appendChild(bubble)
    
    let closeButton = document.querySelector(".close p")
    let timerBar = document.querySelector(".progressbar")


    closeButton.addEventListener("click", ()=>{
        bubble.remove()
    })


    setInterval(()=>{
        timerBar.style.width = 0

    },100)

    setTimeout(()=>{
        if (document.querySelector(".bubble")) {
            bubble.remove()
        }
    },5000)
    
})