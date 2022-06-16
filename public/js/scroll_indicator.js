const scrollIndicator = document.querySelector(".scroll-indicator");
const content = document.querySelector(".content");

const observer = new IntersectionObserver(handleIntersect);

observer.observe(content);

function handleIntersect(entries) {
  const el = entries[0];
  if(el.isIntersecting){
    window.addEventListener("scroll", indicatorAnimation)
  } else if(!el.isIntersecting) {
    window.removeEventListener("scroll", indicatorAnimation)
  }
}


function indicatorAnimation() {

  if(window.scrollY > content.offsetTop) {
    const percentage = ((window.scrollY - content.offsetTop) / content.scrollHeight * 100).toFixed(2);
    console.log(percentage / 100);
    scrollIndicator.style.transform = `scaleX(${(percentage / 100)})`
  } else {
    scrollIndicator.style.transform = "scaleX(0)"
  }

}