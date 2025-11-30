const lenis = new Lenis({
    infinite: true
})
function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);


const menu = document.querySelector(".menu svg");
menu.addEventListener("click", () => {
    gsap.to(".navigation", {
        display: "block",
        y: 0,
        duration: 0.5,
        ease: "power2.out"
    });
    var tl = gsap.timeline({
        delay: 0.3
    });

    tl.from("a", {
        y: 250,
        stagger: 0.1,
        duration: 0.3,
        ease: "ease",
    });
});




function hide() {
    gsap.to(".navigation", {
        display: "none",
        y: -1000,
        duration: 0.5,
        ease: "power2.out"
    });
}

function menuinfo() {
    const homeContainer = document.querySelector(".home-container");

    homeContainer.addEventListener("mouseover", () => {
        gsap.to(".home-container::before", {
            duration: 0.1,
            transformOrigin: "left"
        });
        gsap.to(".home-container a", {
            color: "#fff"
        });
        gsap.to(".line1", {
            rotate: "-45deg",
            backgroundColor: "#fff"
        });
        gsap.to(".line2", {
            rotate: "45deg",
            backgroundColor: "#fff"
        });
        gsap.to(".home-container button", {
            backgroundColor: "#000",
            border: "1px solid #fff",
            // delay: 0.2,

        });
    });

    homeContainer.addEventListener("mouseout", () => {
        gsap.to(".home-container::before", {
            duration: 0.1,
            transformOrigin: "left",
        });
        gsap.to(".home-container button", {
            backgroundColor: "#fff",
            border: "1px solid #000",
        });
        gsap.to(".line1,.line2", {
            rotate: "0deg",
            backgroundColor: "#000"
        });
        gsap.to(".home-container a", {
            color: "#000"
        });
    });

    const productContainer = document.querySelector(".product-container");

    productContainer.addEventListener("mouseover", () => {
        gsap.to(".product-container::before", {
            duration: 0.1,
            transformOrigin: "left"
        });
        gsap.to(".product-container a", {
            color: "#fff"
        });
    });

    productContainer.addEventListener("mouseout", () => {
        gsap.to(".product-container::before", {
            duration: 0.1,
            transformOrigin: "left",
        });
        gsap.to(".product-container a", {
            color: "#000"
        });
    });

    const AboutContainer = document.querySelector(".About-container");

    AboutContainer.addEventListener("mouseover", () => {
        gsap.to(".About-container::before", {
            duration: 0.1,
            transformOrigin: "left"
        });
        gsap.to(".About-container a", {
            color: "#fff"
        });
    });

    AboutContainer.addEventListener("mouseout", () => {
        gsap.to(".About-container::before", {
            duration: 0.1,
            transformOrigin: "left",
        });
        gsap.to(".About-container a", {
            color: "#000"
        });
    });
    const FeedbackContainer = document.querySelector(".Feedback-container");

    FeedbackContainer.addEventListener("mouseover", () => {
        gsap.to(".Feedback-container::before", {
            duration: 0.1,
            transformOrigin: "left"
        });
        gsap.to(".Feedback-container a", {
            color: "#fff"
        });
    });

    FeedbackContainer.addEventListener("mouseout", () => {
        gsap.to(".Feedback-container::before", {
            duration: 0.1,
            transformOrigin: "left",
        });
        gsap.to(".Feedback-container a", {
            color: "#000"
        });
    });


}

menuinfo();
