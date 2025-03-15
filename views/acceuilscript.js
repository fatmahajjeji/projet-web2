function changeTab(selectedTab) {
    // Get all tab buttons
    var tabButtons = document.querySelectorAll('#pillNav2 .nav-link');
    
    // Parcourt chaque bouton
    tabButtons.forEach(function(button) {
        button.classList.remove('active');
        button.setAttribute('aria-selected', 'false');
    });
    
    // Ajoute la classe active au bouton sélectionné
    var activeButton = document.getElementById(selectedTab + '-tab2');
    activeButton.classList.add('active');
    activeButton.setAttribute('aria-selected', 'true');
}




const slides = document.querySelector('.slides');
const imagecontainer=document.querySelector('.image')



setTimeout(() => {
    imagecontainer.setAttribute('src',  '../uploads/infolab1.jpg');
},4000);  

const images = [
    '../uploads/1.jpg',
    '../uploads/infolab4.jpg',
    '../uploads/3.jpg',
];


let currentIndex = 0;


function changeImage() {
    currentIndex = (currentIndex + 1) % images.length;  //Met à jour currentIndex pour passer à l'image suivante. Si currentIndex dépasse la longueur du tableau, il revient à 0 grâce à l'opérateur modulo (%).
    imagecontainer.setAttribute('src', images[currentIndex]); 

}


setInterval(changeImage, 4000); 





function navigateTo(url, tab) {
    changeTab(tab); 
    window.location.href = url;
}