let iconLink = document.querySelector('.logo')
let iconImage = document.querySelector('header .logo  img')

iconLink.addEventListener("mouseenter", e=>{
    iconImage.src="../../../src/maxwell-cat.gif"
})

iconLink.addEventListener("mouseout", e=>{
    iconImage.src="../../src/maxwell-cat.png"
})