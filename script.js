// Smooth scroll functionality
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Intersection Observer for fade-in animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
        }
    });
});

document.querySelectorAll('.card').forEach((card) => {
    observer.observe(card);
});

// Dynamic counter for impact statistics
function animateCounter(element, target) {
    let current = 0;
    const increment = target / 100;
    const timer = setInterval(() => {
        current += increment;
        element.textContent = Math.floor(current);
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        }
    }, 20);
}


    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });

// Add this to your script.js
document.querySelector('.card').addEventListener('click', function() {
    const detailsSection = document.getElementById('marine-conservation-details');
    detailsSection.style.display = 'block';
    detailsSection.scrollIntoView({ behavior: 'smooth' });
});
// Add this code to a new file called script.js or add it at the end of your HTML inside <script> tags

document.addEventListener('DOMContentLoaded', function() {
    // Get the first card (Marine Conservation)
    const marineCard = document.querySelector('.initiative-cards .card:first-child');
    
    // Get the details section
    const detailsSection = document.getElementById('marine-conservation-details');
    
    // Add click event listener to the Marine Conservation card
    marineCard.addEventListener('click', function() {
        if (detailsSection.style.display === 'none' || !detailsSection.style.display) {
            // Show the section
            detailsSection.style.display = 'block';
            
            // Force a reflow before adding the active class
            void detailsSection.offsetWidth;
            
            // Add active class for animation
            detailsSection.classList.add('active');
            
            // Smooth scroll to the details section
            setTimeout(() => {
                detailsSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start' 
                });
            }, 100);
        }
    });
});
// Add this to your script.js
document.addEventListener('DOMContentLoaded', function() {
    const marineCard = document.querySelector('.initiative-cards .card:first-child');
    const detailsSection = document.getElementById('marine-conservation-details');
    
    marineCard.addEventListener('click', function() {
        if (detailsSection.style.display === 'none' || !detailsSection.style.display) {
            detailsSection.style.display = 'block';
            setTimeout(() => {
                detailsSection.classList.add('active');
                detailsSection.scrollIntoView({ behavior: 'smooth' });
            }, 10);
        }
    });
});
// Add this to your script.js
document.addEventListener('DOMContentLoaded', function() {
    // Get all initiative cards
    const cards = document.querySelectorAll('.initiative-cards .card');
    
    // Add click event to each card
    cards.forEach((card, index) => {
        card.addEventListener('click', function() {
            // Hide all detail sections first
            document.querySelectorAll('.details-section').forEach(section => {
                section.classList.remove('active');
                section.style.display = 'none';
            });
            
            // Get the corresponding details section based on card index
            let sectionId;
            switch(index) {
                case 0:
                    sectionId = 'marine-conservation-details';
                    break;
                case 1:
                    sectionId = 'research-details';
                    break;
                case 2:
                    sectionId = 'coastal-details';
                    break;
                case 3:
                    sectionId = 'policy-details';
                    break;
            }
            
            // Show and animate the relevant section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
                // Force reflow
                void targetSection.offsetWidth;
                targetSection.classList.add('active');
                
                // Smooth scroll to section
                targetSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
// Add this to your script.js or within <script> tags
document.addEventListener('DOMContentLoaded', function() {
    // Get all initiative cards
    const cards = document.querySelectorAll('.initiative-cards .card');
    const detailsSection = document.getElementById('pollution-details');

    cards.forEach((card, index) => {
        card.addEventListener('click', function() {
            // Get the title of the clicked card
            const cardTitle = this.querySelector('h3').textContent;
            
            // Update content based on which card was clicked
            updateContent(cardTitle);
            
            // Show the details section
            detailsSection.style.display = 'block';
            setTimeout(() => {
                detailsSection.classList.add('active');
                detailsSection.scrollIntoView({ behavior: 'smooth' });
            }, 10);
        });
    });

    function updateContent(cardTitle) {
        // Get elements to update
        const headerTitle = detailsSection.querySelector('.detail-header h2');
        const headerDesc = detailsSection.querySelector('.detail-header p');
        const causesSection = detailsSection.querySelector('.detail-section:nth-child(2)');
        const effectsSection = detailsSection.querySelector('.detail-section:nth-child(3)');
        const preventionSection = detailsSection.querySelector('.detail-section:nth-child(4)');

        // Update content based on card clicked
        switch(cardTitle) {
            case 'Marine Conservation':
                // Keep existing oil spills content
                break;

            case 'Research & Innovation':
                headerTitle.textContent = 'Plastic Pollution in Marine Environment';
                headerDesc.textContent = 'Understanding the impact of plastic waste on marine ecosystems';
                
                // Update Causes section
                causesSection.querySelector('h3').textContent = 'Why Does Plastic Pollution Happen?';
                causesSection.querySelector('.detail-list').innerHTML = `
                    <li><strong>Single-Use Plastics:</strong> Excessive production and use of disposable plastic items</li>
                    <li><strong>Poor Waste Management:</strong> Inadequate recycling facilities and waste disposal systems</li>
                    <li><strong>Microplastics:</strong> Breakdown of larger plastics and microbeads from products</li>
                    <li><strong>Industrial Discharge:</strong> Plastic pellets and manufacturing waste entering waterways</li>
                `;

                // Update Effects section
                effectsSection.querySelector('h3').textContent = 'Environmental Effects';
                effectsSection.querySelector('.detail-list').innerHTML = `
                    <li><strong>Wildlife Entanglement:</strong> Marine animals trapped in plastic debris</li>
                    <li><strong>Ingestion:</strong> Animals mistaking plastic for food, leading to starvation</li>
                    <li><strong>Habitat Destruction:</strong> Plastic accumulation damaging coral reefs and seabeds</li>
                    <li><strong>Food Chain Contamination:</strong> Microplastics entering the marine food web</li>
                `;

                // Update Prevention section
                preventionSection.querySelector('h3').textContent = 'Prevention & Solutions';
                preventionSection.querySelector('.detail-list').innerHTML = `
                    <li><strong>Plastic Bans:</strong> Legislation prohibiting single-use plastics</li>
                    <li><strong>Recycling Innovation:</strong> Advanced recycling technologies and facilities</li>
                    <li><strong>Alternative Materials:</strong> Development of biodegradable products</li>
                    <li><strong>Public Awareness:</strong> Education campaigns about plastic pollution</li>
                `;

                // Update images
                updateImages('plastic-pollution');
                break;

            case 'Coastal Protection':
                // Similar updates for Coastal Protection content
                break;

            case 'Policy & Advocacy':
                // Similar updates for Policy & Advocacy content
                break;
        }
    }

    function updateImages(type) {
        const images = {
            'plastic-pollution': {
                causes: 'https://images.unsplash.com/photo-1606041008023-472dfb5e530f',
                effects: 'https://images.unsplash.com/photo-1483683804023-6ccdb62f86ef',
                prevention: 'https://images.unsplash.com/photo-1562077772-3bd90403f7f0'
            }
            // Add more image sets for other types
        };

        if (images[type]) {
            detailsSection.querySelector('.detail-section:nth-child(2) img').src = images[type].causes;
            detailsSection.querySelector('.detail-section:nth-child(3) img').src = images[type].effects;
            detailsSection.querySelector('.detail-section:nth-child(4) img').src = images[type].prevention;
        }
    }
});




document.addEventListener('DOMContentLoaded', function () {
    // Select the mic button from the nav (it has the class "talk")
    const micButton = document.querySelector('.talk');
  
    // Initialize the Speech Recognition API
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();
  
    // Optional: Provide feedback via console when the mic is clicked and listening starts
    micButton.addEventListener('click', function () {
      console.log("Listening...");
      recognition.start();
    });
  
    // When a speech result is returned, process the command
    recognition.onresult = function (event) {
      const transcript = event.results[event.resultIndex][0].transcript;
      console.log("Heard:", transcript);
      takeCommand(transcript.toLowerCase());
    };
  
    // Speech synthesis function used to respond aurally
    function speak(text) {
      const utterThis = new SpeechSynthesisUtterance(text);
      utterThis.rate = 1;
      utterThis.pitch = 1;
      utterThis.volume = 1;
      window.speechSynthesis.speak(utterThis);
    }
  
    // Function to process commands based on the recognized speech
    function takeCommand(message) {
      if (message.includes('hey') || message.includes('hello')) {
        speak("Hello Sir, How May I Help You?");
      } else if (message.includes('who am i') || message.includes('who is your master') || message.includes("who created you")) {
        speak("You are Prince, my master, who created me.");
      } else if (message.includes("open google")) {
        window.open("https://google.com", "_blank");
        speak("Opening Google...");
      } else if (message.includes("open youtube")) {
        window.open("https://youtube.com", "_blank");
        speak("Opening Youtube...");
      } else if (message.includes("open facebook")) {
        window.open("https://facebook.com", "_blank");
        speak("Opening Facebook...");
      } else if (message.includes('what is') || message.includes('who is') || message.includes('what are')) {
        window.open(`https://www.google.com/search?q=${message.replace(/\\s/g, "+")}`, "_blank");
        speak("This is what I found on the internet regarding " + message);
      } else if (message.includes('wikipedia')) {
        window.open(`https://en.wikipedia.org/wiki/${message.replace("wikipedia", "").trim()}`, "_blank");
        speak("This is what I found on Wikipedia regarding " + message);
      } else if (message.includes('time')) {
        const time = new Date().toLocaleString(undefined, { hour: "numeric", minute: "numeric" });
        speak("The current time is " + time);
      } else if (message.includes('date')) {
        const date = new Date().toLocaleString(undefined, { month: "short", day: "numeric" });
        speak("Today's date is " + date);
      } else if (message.includes('calculator')) {
        window.open('Calculator:///', "_blank");
        speak("Opening Calculator");
      } else if (message.includes('wordpad')) {
        window.open('WordPad:///', "_blank");
        speak("Opening Word Pad");
      } else {
        window.open(`https://www.google.com/search?q=${message.replace(/\\s/g, "+")}`, "_blank");
        speak("I found some information for " + message + " on Google");
      }
    }
  });
  