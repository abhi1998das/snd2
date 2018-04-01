/*
 * IIFE to keep code safe and outside the global namespace
 */
(function(){

    /*
     * Declaring a factory service as part of the existing turtleFacts Module.
     */
    angular
        .module("turtleFacts")
        .factory("DataService", DataService);

    /*
     * Actual definition of the function used for this factory
     */
    function DataService(){
        /*
         * dataObj is used to simulate getting the data from a backend server
         * The object will hold data which will then be returned to the other
         * factory declared in js/factory/quiz.js which has this factory
         * as a dependency
         */

        var dataObj = {
            turtlesData: turtlesData,
            quizQuestions: quizQuestions,
            correctAnswers: correctAnswers
        };

        // returning the dataObj to anything that uses this factory as a 
        // dependency
        return dataObj;
    }

    /*
     * all of the below variables are simulating data that would typically be 
     * retrieved using an HTTP call to an API endpoint.
     *
     * For simplicity sake this data is hardcoded into the app as this tutorial
     * is about building the angular app, not the backend.
     *
     * The correctAnswers variable would be retrieved when the user has 
     * finished the quiz and would be used to mark the users answers against 
     * the correct answers
     *
     * the quizQuestions is an array of objects, each containing data 
     * pertaining to a single question. This includes:
     *                          - The type of question: image or text
     *                          - Text of the question (aka the actual question)
     *                          - A set of 4 possible answers, either text or 
     *                              images as indicated above
     *                          - a selected flag which will be used to know if
     *                              the user has selected 
     *                          an answer yet.
     *                          - Whether the user got the question correct or 
     *                              not
     *
     * The final turtleData variable hold the information that will be 
     * displayed in the list view when the app loads. This includes the name 
     * and an image of each turtle as well as other information such as the 
     * location and the size of the turtles
     *
     */

    var correctAnswers = [1, 2, 0, 2, 1, 3, 2, 3, 0];

    var quizQuestions  = [
        {
            type: "text",
            text: " What is the fastest water animal?",
            possibilities: [
                {
                    answer: "Porpoise"
                },
                {
                    answer: "Sailfish"
                },
                {
                    answer: "Flying fish"
                },
                {
                    answer: "Tuna"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: "What are female elephants called?",
            possibilities: [
                {
                    answer: "Mares"
                },
                {
                    answer: "Sows"
                },
                {
                    answer: "Cows"
                },
                {
                    answer: "Dams"
                }
            ],
            selected: null,
            correct: null
        },
       
        {
            type: "image",
            text: "Which of these is the Grizzly Bear?",
            possibilities: [
                {
                    answer: "https://imgur.com/Xn4MueL.jpg"
                },
                {
                    answer: "https://imgur.com/yV3MmVf.jpg"
                },
                {
                    answer: "https://imgur.com/XTllamB.jpg"
                },
                {
                    answer: "https://imgur.com/9qTIt7r.jpg"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: " What is the biggest animal that has ever lived?",
            possibilities: [
                {
                    answer: "African elephant"
                },
                {
                    answer: "Apatosaurus 'aka brontosaurus'"
                },
                {
                    answer: "Blue whale"
                },
                {
                    answer: "Spinosaurus"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: "Which of the following animals sleep standing up?",
            possibilities: [
                {
                    answer: "Gorillas"
                },
                {
                    answer: "Flamingos"
                },
                {
                    answer: "Camels"
                },
                {
                    answer: "Ravens"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: " What existing bird has the largest wingspan?",
            possibilities: [
                {
                    answer: "Stork"
                },
                {
                    answer: "Swan"
                },
                {
                    answer: "Condor"
                },
                {
                    answer: "Albatross"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "image",
            text: "Which of these is the Jaguar?",
            possibilities: [
                {
                    answer: "https://imgur.com/bNetVgO.jpg"
                },
                {
                    answer: "https://imgur.com/k3hrex9.jpg"
                },
                {
                    answer: "https://imgur.com/31kDUaZ.jpg"
                },
                {
                    answer: "https://imgur.com/SunMfV0.jpg"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: "Which of the following dogs is the smallest?",
            possibilities: [
                {
                    answer: "Dachshund"
                },
                {
                    answer: "Poodle"
                },
                {
                    answer: "Pomeranian"
                },
                {
                    answer: "Chihuahua"
                }
            ],
            selected: null,
            correct: null
        },
        {
            type: "text",
            text: "What type of animal is a seahorse?",
            possibilities: [
                {
                    answer: "Crustacean"
                },
                {
                    answer: "Arachnid"
                },
                {
                    answer: "Fish"
                },
                {
                    answer: "Shell"
                }
            ],
            selected: null,
            correct: null
        }
    ];

    var turtlesData = [
        {
            type: "Hyena",
            image_url: "https://imgur.com/lCj3yA8.jpg",
            locations: "  grasslands, savannas, deserts, forests and mountains.",
            size: "Up to 95 – 170 cm and 44 – 64 kg",
            lifespan: " 20 years",
            diet: "Carnivore",
            description: "Although phylogenetically they are closer to felines and viverrids, and belong to the feliform category, hyenas are behaviourally and morphologically similar to canines in several elements of convergent evolution; both hyenas and canines are non-arboreal, cursorial hunters that catch prey with their teeth rather than claws. Both eat food quickly and may store it, and their calloused feet with large, blunt, nonretractable claws are adapted for running and making sharp turns. However, the hyenas' grooming, scent marking, defecating habits, mating and parental behaviour are consistent with the behaviour of other feliforms."
        },
        {
            type: "Elephant",
            image_url: "https://imgur.com/F8IgMiC.jpg",
            locations: "Savannah zones in 37 countries south of the Sahara Desert. ",
            size: " 5.5 – 6.5 m,  5,400 kg",
            lifespan: "More than 50 years",
            diet: "Hervivore",
            description: "All elephants have several distinctive features, the most notable of which is a long trunk (also called a proboscis), used for many purposes, particularly breathing, lifting water, and grasping objects. Their incisors grow into tusks, which can serve as weapons and as tools for moving objects and digging. Elephants' large ear flaps help to control their body temperature. Their pillar-like legs can carry their great weight. African elephants have larger ears and concave backs while Asian elephants have smaller ears and convex or level backs."
        },
        {
            type: "Lion",
            image_url: "https://imgur.com/q45PCNm.jpg",
            locations: "Angola, Mozambique, Tanzania, the Central African Republic",
            size: "Up to 1.7 – 2.5 m, up to 190kg",
            lifespan: "14 years",
            diet: "Carnivore",
            description: "The lion typically inhabits grasslands and savannahs, but is absent in dense forests. It is usually more diurnal than other big cats, but when persecuted adapts to being active at night and at twilight. A lion pride consists of a few adult males, related females and cubs. Prides vary in size and composition from three to 20 adult lions, depending on habitat and prey availability. Females cooperate when hunting and prey mostly on large ungulates, including antelope, deer, buffalo, zebra and even giraffe."
        },
        {
            type: "Leopard",
            image_url: "https://imgur.com/i5jHTLS.jpg",
            locations: "Africa and , China, India, and Malaysia",
            size: "90 – 160 cm, up to  31 kg",
            lifespan: "12 – 17 years",
            diet: "Carnivore",
            description: "Compared to other wild cats, the leopard has relatively short legs and a long body with a large skull. It is similar in appearance to the jaguar, but generally has a smaller, lighter physique. Its fur is marked with rosettes similar to those of the jaguar, but the leopard's rosettes are smaller and more densely packed, and do not usually have central spots as the jaguar's do. Both leopards and jaguars that are melanistic are known as black panthers. The leopard is distinguished by its well-camouflaged fur, opportunistic hunting behaviour, broad diet, and strength (which it uses to move heavy carcasses into trees), as well as its ability to adapt to various habitats ranging from rainforest to steppe, including arid and montane areas, and its ability to run at speeds of up to 58 kilometres per hour (36 mph).[8]"
        },
        {
            type: "Wild water buffalo",
            image_url: "https://imgur.com/wrWH8w2.jpg",
            locations: "Tropical and subtropical forests of Asia.",
            size: " 2.6 m, up to 300 – 550 kg",
            lifespan: "25 years",
            diet: "Hervivore",
            description: "The wild water buffalo (Bubalus arnee), also called Asian buffalo, Asiatic buffalo and wild Asian buffalo, is a large bovine native to the Indian Subcontinent and Southeast Asia. It has been listed as Endangered in the IUCN Red List since 1986, as the remaining population totals less than 4,000. A population decline of at least 50% over the last three generations (24–30 years) is projected to continue.[1] The global population has been estimated at 3,400 individuals, of which 3,100 (91%) live in India, mostly in Assam.[3] The wild water buffalo is the probable ancestor of the domestic water buffalo."
        },
        {
            type: "Gorilla",
            image_url: "https://imgur.com/WciuxfP.jpg",
            locations: " tropical forests of Cameroon, African Republic",
            size: "1.6 – 1.7 m, up to 160 kg",
            lifespan: "35 – 40 years",
            diet: "Omnivore",
            description: "Gorillas' natural habitats cover tropical or subtropical forests in Sub-Saharan Africa. Although their range covers a small percentage of Africa, gorillas cover a wide range of elevations. The mountain gorilla inhabits the Albertine Rift montane cloud forests of the Virunga Volcanoes, ranging in altitude from 2,200–4,300 metres (7,200–14,100 ft). Lowland gorillas live in dense forests and lowland swamps and marshes as low as sea level, with western lowland gorillas living in Central West African countries and eastern lowland gorillas living in the Democratic Republic of the Congo near its border with Rwanda."
        },
        {
            type: "Alligator",
            image_url: "https://imgur.com/3ecdN34.jpg",
            locations: "freshwater environments, such as ponds, marshes, wetlands",
            size: "3 – 4.6 m, 230 kg",
            lifespan: "30 – 50 years",
            diet: "Carnivore",
            description: "An alligator is a crocodilian in the genus Alligator of the family Alligatoridae. The two living species are the American alligator (A. mississippiensis) and the Chinese alligator (A. sinensis). In addition, several extinct species of alligator are known from fossil remains. Alligators first appeared during the Oligocene epoch about 37 million years ago. The name 'alligator' is probably an anglicized form of el lagarto, the Spanish term for 'the lizard', which early Spanish explorers and settlers in Florida called the alligator. Later English spellings of the name included allagarta and alagarto."
        },
        {
            type: "Bear",
            image_url: "https://imgur.com/FpQr3E5.jpg",
            locations: "subalpine meadows, open plains and arctic tundra",
            size: "1.2 – 1.9 m,80 – 600 kg",
            lifespan: "20 years",
            diet: "Omninivore",
            description: "While the polar bear is mostly carnivorous, and the giant panda feeds almost entirely on bamboo, the remaining six species are omnivorous with varied diets. With the exception of courting individuals and mothers with their young, bears are typically solitary animals. They may be diurnal or nocturnal and have an excellent sense of smell. Despite their heavy build and awkward gait, they are adept runners, climbers, and swimmers. Bears use shelters, such as caves and logs, as their dens; most species occupy their dens during the winter for a long period of hibernation, up to 100 days."
        }
    ];

})();
