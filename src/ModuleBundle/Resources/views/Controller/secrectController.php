<?php
/**
 * Created by PhpStorm.
 * User: Ameni
 * Date: 18/07/2017
 * Time: 08:44
 */

namespace ModuleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AdminBundle\Entity\Mark;
use AdminBundle\Entity\Model;

class secrectController extends Controller
{
    public function addMarksAction()
    {
        $em = $this->getDoctrine()->getManager();
$array=array(

    array(
        "models"
        =>
            array(
                "Choisir un modèle"),"name"=>
        "Choisir une marque",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "MDX",
                "NSX",
                "RL",
                "RSX",
                "TL",
                "TSX"),"name"=>
        "Acura",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "City",
                "Crossline",
                "Roadline",
                "Scouty R"),"name"=>
        "Aixam",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "145",
                "146",
                "147",
                "149",
                "155",
                "156",
                "159",
                "164",
                "166",
                "33",
                "75",
                "8C",
                "90",
                "Alfasud",
                "Alfetta",
                "Autre",
                "Brera",
                "Crosswagon",
                "Giulia",
                "Giulietta",
                "GT",
                "GTV",
                "Junior",
                "Mito",
                "RZ/SZ",
                "Spider",
                "Sprint"),"name"=>
        "Alfa Romeo",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "B10",
                "B12",
                "B3",
                "B5",
                "B6",
                "B7",
                "B8",
                "D 10",
                "D3",
                "Roadster S"),"name"=>
        "Alpina",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "AR1",
                "DB",
                "DB7",
                "DB9",
                "DBS",
                "Lagonda",
                "Rapide",
                "V12 Vantage",
                "V8",
                "V8 Vantage",
                "Vanquish",
                "Vantage",
                "Virage",
                "Volante"),"name"=>
        "Aston Martin",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "100",
                "200",
                "80",
                "90",
                "A1",
                "A1 Sportback",
                "A2",
                "A3",
                "A3 Berline",
                "A3 Sportback",
                "A4",
                "A5 Cabriolet",
                "A5 Coupé",
                "A5 sportback",
                "A6",
                "A6 Allroad",
                "A7 Sportback",
                "A8",
                "Autre",
                "Cabriolet",
                "Coupé",
                "Q2",
                "Q3",
                "Q5",
                "Q7",
                "Quattro",
                "R8",
                "RS2",
                "RS4",
                "RS5",
                "RS6",
                "S3",
                "S4",
                "S5",
                "S6",
                "S7",
                "S8",
                "TT",
                "TT RS",
                "TTS",
                "V8"),"name"=>
        "Audi",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Kenbo S2",
                "Kenbo S3"),"name"=>
        "BAIC YX",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Arnage",
                "Azure",
                "Brooklands",
                "Continental",
                "Eight",
                "Mulsanne",
                "Turbo R",
                "Turbo RT",
                "Turbo S"),"name"=>
        "Bentley",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Autre",
                "M1",
                "M3",
                "M4",
                "M5",
                "M6",
                "Série 1 3p",
                "Série 1 5p",
                "Série 2 Active Tourer",
                "Série 2 Coupé",
                "Série 3",
                "Série 3 cabriolet",
                "Série 3 coupé",
                "Série 3 GT",
                "Série 4 Coupé",
                "Série 4 Gran Coupé",
                "Série 5",
                "Série 5 GT",
                "Série 6",
                "Série 6 Cabriolet",
                "Série 6 Gran Coupé",
                "Série 7",
                "Série 8",
                "X1",
                "X3",
                "X4",
                "X5",
                "X6",
                "Z1",
                "Z3",
                "Z4",
                "Z8"),"name"=>
        "BMW",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "EB 110",
                "La Crosse",
                "Veyron"),"name"=>
        "Bugatti",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Century",
                "Electra",
                "Enclave",
                "Le Sabre",
                "Park Avenue",
                "Regal",
                "Riviera",
                "Roadmaster",
                "Skylark"),"name"=>
        "Buick",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Allante",
                "BLS",
                "CTS",
                "Deville",
                "Eldorado",
                "Escalade",
                "Fleetwood",
                "Seville",
                "SRX",
                "STS",
                "XLR"),"name"=>
        "Cadillac",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Arrizo 5",
                "E3",
                "QQ"),"name"=>
        "Chery",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "2500",
                "Alero",
                "Astro",
                "Autre",
                "Avalanche",
                "Aveo",
                "Beretta",
                "Blazer",
                "C1500",
                "Camaro",
                "Caprice",
                "Captiva",
                "Cavalier",
                "Chevelle",
                "Chevy Van",
                "Citation",
                "Colorado",
                "Corsica",
                "Cruze",
                "Cruze 5P",
                "El Camino",
                "Epica",
                "Evanda",
                "G",
                "HHR",
                "Impala",
                "K1500",
                "K30",
                "Kalos",
                "Lacetti",
                "Lumina",
                "Malibu",
                "Matiz",
                "Nubira",
                "Optra",
                "Rezzo",
                "S-10",
                "Silverado",
                "Sonic",
                "Sonic 4p",
                "Spark",
                "SSR",
                "Suburban",
                "Tahoe",
                "Trailblazer",
                "Trans Sport",
                "Venture"),"name"=>
        "Chevrolet",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "300 M",
                "300C",
                "Aspen",
                "Autre",
                "Crossfire",
                "Daytona",
                "ES",
                "Grand Voyager",
                "GS",
                "GTS",
                "Imperial",
                "Le Baron",
                "Neon",
                "New Yorker",
                "Pacifica",
                "PT Cruiser",
                "Saratoga",
                "Sebring",
                "Stratus",
                "Valiant",
                "Viper",
                "Vision",
                "Voyager"),"name"=>
        "Chrysler",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "2 CV",
                "Autre",
                "AX",
                "Berlingo",
                "Berlingo First",
                "Berlingo Utilitaire",
                "BX",
                "C-Crosser",
                "C-Elysée",
                "C1",
                "C2",
                "C3",
                "C3 Picasso",
                "C4",
                "C4 Aircross",
                "C4 Cactus",
                "C4 Coupé",
                "C4 Picasso",
                "C5",
                "C6",
                "C8",
                "CX",
                "DS",
                "DS3",
                "DS4",
                "DS5",
                "Evasion",
                "Grand C4 Picasso",
                "GSA",
                "Jumper",
                "Jumpy Combi",
                "Jumpy Fourgon",
                "Nemo",
                "Saxo",
                "SM",
                "Visa",
                "Xantia",
                "XM",
                "Xsara",
                "Xsara Picasso",
                "ZX"),"name"=>
        "Citroën",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Autre",
                "Dokker",
                "Dokker Van",
                "Duster",
                "Lodgy",
                "Logan",
                "Logan MCV",
                "Logan Van",
                "Pick Up",
                "Sandero"),"name"=>
        "Dacia",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Autre",
                "Espero",
                "Evanda",
                "Kalos",
                "Korando",
                "Lacetti",
                "Lanos",
                "Leganza",
                "Matiz",
                "Musso",
                "Nexia",
                "Nubira",
                "Rezzo",
                "Tacuma"),"name"=>
        "Daewoo",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Applause",
                "Autre",
                "Charade",
                "Charmant",
                "Copen",
                "Cuore",
                "Feroza/Sportrak",
                "Freeclimber",
                "Gran Move",
                "Hijet",
                "MATERIA",
                "Move",
                "Rocky/Fourtrak",
                "Sirion",
                "Terios",
                "TREVIS",
                "YRV"),"name"=>
        "Daihatsu",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Autre",
                "Avenger",
                "Caliber",
                "Challenger",
                "Charger",
                "Dakota",
                "Demon",
                "Durango",
                "Grand Caravan",
                "Hornet",
                "Journey",
                "Magnum",
                "Neon",
                "Nitro",
                "RAM",
                "Stealth",
                "Viper"),"name"=>
        "Dodge",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "3",
                "3 Cabrio",
                "4",
                "4 Crossback",
                "5"),"name"=>
        "DS",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "208",
                "246",
                "250",
                "275",
                "288",
                "308",
                "328",
                "330",
                "348",
                "360",
                "365",
                "400",
                "412",
                "456",
                "458",
                "512",
                "550",
                "575",
                "599 GTB",
                "612",
                "750",
                "Autre",
                "California",
                "Daytona",
                "Dino GT4",
                "Enzo Ferrari",
                "F355",
                "F40",
                "F430",
                "F50",
                "Mondial",
                "Superamerica",
                "Testarossa"),"name"=>
        "Ferrari",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "124",
                "126",
                "127",
                "130",
                "131",
                "500",
                "500 Abarth",
                "500 C",
                "500L",
                "500X",
                "Autre",
                "Barchetta",
                "Brava",
                "Bravo",
                "Cinquecento",
                "Coupe",
                "Croma",
                "Dino",
                "Doblo",
                "Ducato",
                "Fiorino",
                "Grande Punto",
                "Grande Punto Abarth",
                "Idea",
                "Linea",
                "Marea",
                "Marengo",
                "Multipla",
                "Palio",
                "Panda",
                "Punto Classic",
                "Punto Easy",
                "Punto Evo",
                "Punto Pop",
                "Qubo",
                "Regata",
                "Ritmo",
                "Scudo",
                "Sedici",
                "Seicento",
                "Siena",
                "Spider Europa",
                "Stilo",
                "Strada",
                "Tempra",
                "Tipo",
                "Tipo Berline",
                "Ulysse",
                "Uno",
                "X 1/9"),"name"=>
        "Fiat",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Aerostar",
                "Autre",
                "B-Max",
                "Bronco",
                "C-Max",
                "Capri",
                "Cougar",
                "Courier",
                "Crown",
                "Econoline",
                "Econovan",
                "Ecosport",
                "Edge",
                "Escape",
                "Escort",
                "Excursion",
                "Expedition",
                "Explorer",
                "Express",
                "F 150",
                "F 250",
                "F 350",
                "Fairlane",
                "Falcon",
                "Fiesta",
                "Figo",
                "Focus",
                "Focus berline",
                "Focus C-Max",
                "Fusion",
                "Galaxy",
                "Granada",
                "Grand C-Max",
                "GT",
                "Ka",
                "Kuga",
                "Maverick",
                "Mercury",
                "Mondeo",
                "Mustang",
                "Orion",
                "Probe",
                "Puma",
                "Ranger",
                "S-Max",
                "Scorpio",
                "Sierra",
                "Sportka",
                "Streetka",
                "Taunus",
                "Taurus",
                "Thunderbird",
                "Tourneo",
                "Transit",
                "Windstar"),"name"=>
        "Ford",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Autre",
                "Envoy",
                "Safari",
                "Savana",
                "Sierra",
                "Sonoma",
                "Syclone",
                "Typhoon",
                "Vandura",
                "Yukon"),"name"=>
        "GMC",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "C30",
                "H5",
                "M4",
                "Wingle 5",
                "Wingle 6"),"name"=>
        "Great Wall",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "H2",
                "H6",
                "H8",
                "H9"),"name"=>
        "Haval",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Accord",
                "Aerodeck",
                "Autre",
                "Brio",
                "Brio Amaze",
                "City",
                "Civic",
                "Concerto",
                "CR-V",
                "CR-Z",
                "CRX",
                "Element",
                "FR-V",
                "HR-V",
                "Insight",
                "Integra",
                "Jazz",
                "Legend",
                "Logo",
                "NSX",
                "Odyssey",
                "Prelude",
                "S2000",
                "Shuttle",
                "Stream"),"name"=>
        "Honda",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "H1",
                "H2",
                "H3"),"name"=>
        "Hummer",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Accent",
                "Accent 5p",
                "Atos",
                "Autre",
                "Azera",
                "Coupe",
                "Elantra",
                "Excel",
                "Galloper",
                "Genesis",
                "Getz",
                "Grand i10",
                "Grand i10 Sedan",
                "Grand Santa Fe",
                "Grandeur",
                "H 100",
                "H 200",
                "H-1",
                "H-1 Starex",
                "i10",
                "i20",
                "i30",
                "i40",
                "i50",
                "ix20",
                "ix35",
                "ix55",
                "Lantra",
                "Matrix",
                "Pony",
                "S-Coupe",
                "Santa Fe",
                "Santamo",
                "Sonata",
                "Terracan",
                "Trajet",
                "Tucson",
                "Veloster",
                "Veracruz",
                "XG 30",
                "XG 350"),"name"=>
        "Hyundai",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "EX35",
                "EX37",
                "FX",
                "G35",
                "G37",
                "Q45",
                "QX56"),"name"=>
        "Infiniti",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Campo",
                "D-Max",
                "Gemini",
                "Midi",
                "PICK UP",
                "Trooper"),"name"=>
        "Isuzu",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Daily"),"name"=>
        "Iveco",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Daimler",
                "E-Type",
                "F-Pace",
                "F-Type",
                "MK II",
                "S-Type",
                "X-Type",
                "XE",
                "XF",
                "XJ",
                "XJ12",
                "XJ40",
                "XJ6",
                "XJ8",
                "XJR",
                "XJS",
                "XJSC",
                "XK Cabriolet",
                "XKR"),"name"=>
        "Jaguar",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Cherokee",
                "CJ",
                "Comanche",
                "Commander",
                "Compass",
                "Grand Cherokee",
                "Patriot",
                "Renegade",
                "Wagoneer",
                "Willys",
                "Wrangler"),"name"=>
        "Jeep",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Z1000"),"name"=>
        "Kawazaki",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Besta",
                "Borrego",
                "Cadenza",
                "Carens",
                "Carnival",
                "Cee'd",
                "cee'd Sporty Wagon",
                "Cerato",
                "Cerato 5p",
                "Cerato KOUP",
                "Clarus",
                "Elan",
                "Joice",
                "K2500",
                "K2700",
                "Leo",
                "Magentis",
                "Mentor",
                "Mini",
                "Mohave",
                "Opirus",
                "Optima",
                "Picanto",
                "Pregio",
                "Pride",
                "pro_cee'd",
                "Quoris",
                "Retona",
                "Rio",
                "Rio 5p",
                "Roadster",
                "Rocsta",
                "Sephia",
                "Shuma",
                "Sorento",
                "Soul",
                "Sportage",
                "Venga"),"name"=>
        "KIA",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "110",
                "111",
                "112",
                "1200",
                "2107",
                "2110",
                "2111",
                "2112",
                "Aleko",
                "Forma",
                "Kalina",
                "Niva",
                "Nova",
                "Priora",
                "Samara"),"name"=>
        "Lada",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Aventador",
                "Aventador Roadster",
                "Countach",
                "Diablo",
                "Espada",
                "Gallardo",
                "Jalpa",
                "LM",
                "Miura",
                "Murciélago",
                "Urraco"),"name"=>
        "Lamborghini",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Beta",
                "Dedra",
                "Delta",
                "Flaminia",
                "Fulvia",
                "Gamma",
                "Kappa",
                "Lybra",
                "MUSA",
                "Phedra",
                "Prisma",
                "Stratos",
                "Thema",
                "Thesis",
                "Ypsilon",
                "Zeta"),"name"=>
        "Lancia",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Defender",
                "Discovery",
                "Discovery Sport",
                "Freelander",
                "Range Rover",
                "Range Rover Evoque",
                "Range Rover Sport"),"name"=>
        "Land Rover",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "ES 300",
                "ES 330",
                "ES 350",
                "GS 300",
                "GS 350",
                "GS 430",
                "GS 450",
                "GS 460",
                "GX 470",
                "IS 200",
                "IS 220",
                "IS 250",
                "IS 300",
                "IS 350",
                "IS-F",
                "LS 400",
                "LS 430",
                "LS 460",
                "LS 600",
                "LX 470",
                "LX 570",
                "RX 300",
                "RX 330",
                "RX 350",
                "RX 400",
                "RX 450",
                "SC 400",
                "SC 430"),"name"=>
        "Lexus",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Aviator",
                "Aviator",
                "Continental",
                "LS",
                "Mark",
                "Navigator",
                "Town Car"),"name"=>
        "Lincoln",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "340 R",
                "Cortina",
                "Elan",
                "Elise",
                "Elite",
                "Esprit",
                "Europa",
                "Evora",
                "Excel",
                "Exige",
                "Super Seven",
                "V8"),"name"=>
        "Lotus",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Pick-up DC",
                "Pick-up SC",
                "Scorpio SUV",
                "XUV 500"),"name"=>
        "Mahindra",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "222",
                "224",
                "228",
                "3200",
                "418",
                "420",
                "4200",
                "422",
                "424",
                "430",
                "Biturbo",
                "Ghibli",
                "GranCabrio",
                "Gransport",
                "Granturismo",
                "Indy",
                "Karif",
                "MC12",
                "Merak",
                "Quattroporte",
                "Shamal",
                "Spyder"),"name"=>
        "Maserati",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "121",
                "2",
                "2 Sedan",
                "3",
                "3 sedan",
                "323",
                "5",
                "6",
                "626",
                "929",
                "B series",
                "Bongo",
                "BT-50",
                "BT-50 Pro",
                "CX-3",
                "CX-5",
                "CX-7",
                "CX-9",
                "Demio",
                "E series",
                "Millenia",
                "MPV",
                "MX-3",
                "MX-5",
                "MX-6",
                "Premacy",
                "Protege",
                "RX-6",
                "RX-7",
                "RX-8",
                "Tribute",
                "Xedos"),"name"=>
        "Mazda",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "190",
                "200",
                "220",
                "230",
                "240",
                "250",
                "260",
                "270",
                "280",
                "290",
                "300",
                "320",
                "350",
                "380",
                "400",
                "416",
                "420",
                "450",
                "500",
                "560",
                "600",
                "Autre",
                "CE",
                "CL",
                "CLA",
                "Classe A",
                "Classe B",
                "Classe C",
                "Classe C coupé",
                "Classe E",
                "Classe E coupé",
                "Classe G",
                "Classe GL",
                "Classe R",
                "Classe S",
                "Classe V",
                "CLC",
                "CLK",
                "CLS",
                "GLA",
                "GLC",
                "GLE",
                "GLK",
                "ML",
                "SL",
                "SLK",
                "SLR",
                "SLS",
                "Sprinter",
                "Vaneo",
                "Vario",
                "Viano",
                "Vito"),"name"=>
        "Mercedes-Benz",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "3",
                "GS",
                "GT",
                "MGA",
                "MGB",
                "MGF",
                "Midget",
                "Montego",
                "TD",
                "TF",
                "ZR",
                "ZS",
                "ZT"),"name"=>
        "MG",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "1000",
                "1300",
                "3 portes",
                "5 portes",
                "Cabrio",
                "Clubman",
                "Cooper S",
                "Countryman",
                "Coupé",
                "John Cooper Works",
                "Paceman"),"name"=>
        "Mini",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "ASX",
                "Attrage",
                "Mirage"),"name"=>
        "Mitsubishi",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "3000 GT",
                "Canter",
                "Carisma",
                "Colt",
                "Cordia",
                "Cosmos",
                "Diamante",
                "Eclipse",
                "Galant",
                "Galloper",
                "Grandis",
                "i-MiEV",
                "L200 Double Cabine",
                "L200 Simple Cabine",
                "L300",
                "L400",
                "Lancer",
                "Mirage",
                "Montero",
                "Outlander",
                "Pajero",
                "Pajero",
                "Pajero Pinin",
                "Pick-up",
                "Santamo",
                "Sapporo",
                "Sigma",
                "Space Gear",
                "Space Runner",
                "Space Star",
                "Space Wagon",
                "Starion",
                "Tredia"),"name"=>
        "Mitsubishi",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "4/4",
                "Aero 8",
                "Plus 4",
                "Plus 8"),"name"=>
        "Morgan",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "100 NX",
                "200 SX",
                "240 SX",
                "280 ZX",
                "300 ZX",
                "350Z",
                "370Z",
                "Almera",
                "Almera Tino",
                "Almera Tino",
                "Altima",
                "Armada",
                "Bluebird",
                "Cabstar",
                "Cargo",
                "Cherry",
                "Cube",
                "Frontier",
                "GT-R",
                "Interstar",
                "Juke",
                "King Cab",
                "Kubistar",
                "Laurel",
                "Maxima",
                "Micra",
                "Murano",
                "Navara",
                "Note",
                "NP 300",
                "Pathfinder",
                "Patrol",
                "Pixo",
                "Prairie",
                "Primastar",
                "Primera",
                "Qashqai",
                "Qashqai+2",
                "Quest",
                "Sentra",
                "Serena",
                "Silvia",
                "Skyline",
                "Sunny",
                "Terrano",
                "Tiida",
                "Titan",
                "Trade",
                "Urvan",
                "Vanette",
                "X-trail"),"name"=>
        "Nissan",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Bravada",
                "Custom Cruiser",
                "Cutlass",
                "Delta 88",
                "Silhouette",
                "Supreme",
                "Toronado"),"name"=>
        "Oldsmobile",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "Adam",
                "Agila",
                "Agila",
                "Arena",
                "Ascona",
                "Astra",
                "Astra GTC",
                "Autre",
                "Calibra",
                "Campo",
                "Cavalier",
                "Combo",
                "Commodore",
                "Corsa",
                "Corsa 3p",
                "Diplomat",
                "Frontera",
                "GT",
                "Insignia",
                "Kadett",
                "Manta",
                "Meriva",
                "Monterey",
                "Monza",
                "Movano",
                "Nova",
                "Omega",
                "Pick Up Sportscap",
                "Rekord",
                "Senator",
                "Signum",
                "Sintra",
                "Speedster",
                "Tigra",
                "Vectra",
                "Vivaro",
                "Zafira"),"name"=>
        "Opel",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "1007",
                "104",
                "106",
                "107",
                "108",
                "2008",
                "204",
                "205",
                "206",
                "206 Berline",
                "206+",
                "207",
                "207 cc",
                "208",
                "208 3P",
                "3008",
                "301",
                "304",
                "305",
                "306",
                "306 coupé",
                "307",
                "308",
                "308 cc",
                "309",
                "4007",
                "4008",
                "404",
                "405",
                "406",
                "407",
                "408",
                "5008",
                "504",
                "505",
                "508",
                "604",
                "605",
                "607",
                "806",
                "807",
                "Bipper",
                "Bipper Tepee",
                "Boxer",
                "Expert",
                "Expert Tepee",
                "iOn",
                "J5",
                "Partner",
                "Partner Origin",
                "Partner Origin Utilitaire",
                "Partner Tepee",
                "RCZ",
                "TePee"),"name"=>
        "Peugeot",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "APE",
                "APE TM",
                "Porter"),"name"=>
        "Piaggio",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "6000",
                "Bonneville",
                "Fiero",
                "Firebird",
                "G6",
                "Grand-Am",
                "Grand-Prix",
                "GTO",
                "Montana",
                "Solstice",
                "Sunbird",
                "Sunfire",
                "Targa",
                "Trans Am",
                "Trans Sport",
                "Vibe"),"name"=>
        "Pontiac",
    ),
    array(
        "models"
        =>
            array(
                "Choisir un modèle",
                "356",
                "718 Boxster",
                "718 Cayman",
                "911",
                "912",
                "914",
                "924",
                "928",
                "944",
                "959",
                "962",
                "964",
                "968",
                "993",
                "996",
                "997",
                "Boxster",
                "Carrera GT",
                "Cayenne",
                "Macan",
                "Panamera"),"name"=>
"Porsche"
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Alpine A110",
            "Alpine A310",
            "Alpine V6",
            "Autre",
            "Avantime",
            "Captur",
            "Clio",
            "Clio Campus",
            "Clio Classic",
            "Coupe",
            "Espace",
            "Express",
            "Fluence",
            "Fuego",
            "Grand Espace",
            "Grand Modus",
            "Grand Scenic",
            "Kadjar",
            "Kangoo",
            "Koleos",
            "Laguna",
            "Laguna Coupé",
            "Latitude",
            "Mascott",
            "Master",
            "Megane",
            "Megane CC",
            "Megane coupé",
            "Modus",
            "P 1400",
            "R 11",
            "R 14",
            "R 18",
            "R 19",
            "R 20",
            "R 21",
            "R 25",
            "R 30",
            "R 4",
            "R 5",
            "R 6",
            "R 9",
            "Rapid",
            "Safrane",
            "Scenic",
            "Spider Europa",
            "Symbol",
            "Trafic",
            "Twingo",
            "Vel Satis",
            "Wind"),"name"=>
    "Renault",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Corniche",
            "Flying Spur",
            "Ghost",
            "Park Ward",
            "Phantom",
            "Silver Cloud",
            "Silver Dawn",
            "Silver Seraph",
            "Silver Shadow",
            "Silver Spirit",
            "Silver Spur"),"name"=>
    "Rolls Royce",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "100",
            "111",
            "114",
            "115",
            "200",
            "213",
            "214",
            "216",
            "218",
            "220",
            "25",
            "400",
            "414",
            "416",
            "418",
            "420",
            "45",
            "600",
            "618",
            "620",
            "623",
            "75",
            "800",
            "820",
            "825",
            "827",
            "City Rover",
            "Metro",
            "Montego",
            "SD",
            "Streetwise"),"name"=>
    "Rover",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "9-3",
            "9-4X",
            "9-5",
            "9-7X",
            "90",
            "900",
            "9000",
            "96",
            "99"),"name"=>
    "Saab",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Alhambra",
            "Altea",
            "Arosa",
            "Ateca",
            "Cordoba",
            "Exeo",
            "Ibiza",
            "Inca",
            "Leon",
            "Leon SC",
            "Malaga",
            "Marbella",
            "Mii",
            "Terra",
            "Toledo"),"name"=>
    "Seat",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "105",
            "120",
            "130",
            "135",
            "Fabia",
            "Favorit",
            "Felicia",
            "Forman",
            "Octavia",
            "Pick-up",
            "Praktik",
            "Rapid",
            "Rapid Spaceback",
            "Roomster",
            "Superb",
            "Yeti"),"name"=>
    "Skoda",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Crossblade",
            "ForFour",
            "ForTwo",
            "Roadster"),"name"=>
    "Smart",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Actyon Sports",
            "Chairman",
            "Family",
            "Korando",
            "Kyron",
            "MUSSO",
            "Rexton",
            "Rodius",
            "Tivoli",
            "XLV"),"name"=>
    "Ssangyong",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "B9 Tribeca",
            "Baja",
            "Forester",
            "Impreza",
            "Justy",
            "Legacy",
            "Libero",
            "OUTBACK",
            "SVX",
            "Tribeca",
            "Vivio",
            "XT"),"name"=>
    "Subaru",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Alto",
            "Baleno",
            "Cappuccino",
            "Carry",
            "Celerio",
            "Ciaz",
            "Grand Vitara",
            "Ignis",
            "Jimny",
            "Kizashi",
            "Liana",
            "LJ",
            "SJ Samurai",
            "Splash",
            "Super-Carry",
            "Swift",
            "SX4",
            "Vitara",
            "Wagon R+",
            "X-90"),"name"=>
    "Suzuki",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Horizon",
            "Samba"),"name"=>
    "Talbot",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Indica",
            "Indigo",
            "Nano",
            "Safari",
            "Sumo",
            "Telcoline",
            "Telcosport",
            "Xenon"),"name"=>
    "Tata",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "4-Runner",
            "Auris",
            "Avalon",
            "Avanza",
            "Avensis",
            "Avensis Verso",
            "Aygo",
            "Camry",
            "Carina",
            "Celica",
            "Corolla",
            "Corolla Verso",
            "Cressida",
            "Crown",
            "Dyna",
            "FJ",
            "GT86",
            "Hiace",
            "Highlander",
            "Hilux",
            "IQ",
            "Land Cruiser",
            "Lite-Ace",
            "MR 2",
            "Paseo",
            "Picnic",
            "Prado",
            "Previa",
            "Prius",
            "RAV 4",
            "Sequoia",
            "Sienna",
            "Starlet",
            "Supra",
            "Tacoma",
            "Tercel",
            "Tundra",
            "Urban Cruiser",
            "Verso",
            "Yaris",
            "Yaris Sedan"),"name"=>
    "Toyota",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "601"),"name"=>
    "Trabant",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Dolomite",
            "Moss",
            "Spitfire",
            "TR3",
            "TR4",
            "TR5",
            "TR6",
            "TR7",
            "TR8"),"name"=>
    "Triumph",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Chimaera",
            "Griffith",
            "Tuscan"),"name"=>
    "TVR",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "181",
            "Amarok",
            "Bora",
            "Buggy",
            "Caddy",
            "CC",
            "Corrado",
            "Crafter",
            "Eos",
            "Fox",
            "Golf 1",
            "Golf 2",
            "Golf 3",
            "Golf 4",
            "Golf 5",
            "Golf 6",
            "Golf 7",
            "Golf Cabriolet",
            "Golf Plus",
            "Iltis",
            "Jetta",
            "Karmann Ghia",
            "Käfer",
            "LT",
            "Lupo",
            "Multivan",
            "New Beetle",
            "Passat",
            "Passat CC",
            "Phaeton",
            "Polo",
            "Polo Sedan",
            "Routan",
            "Santana",
            "Scirocco",
            "Sharan",
            "T1",
            "T2",
            "T3",
            "T4",
            "T5",
            "Taro",
            "Tiguan",
            "Touareg",
            "Touran",
            "Transporter",
            "Up",
            "Vento"),"name"=>
    "Volkswagen",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "240",
            "244",
            "245",
            "262",
            "264",
            "340",
            "360",
            "440",
            "460",
            "480",
            "740",
            "744",
            "745",
            "760",
            "780",
            "850",
            "855",
            "940",
            "944",
            "945",
            "960",
            "965",
            "Amazon",
            "C30",
            "C70",
            "Polar",
            "S40",
            "S60",
            "S70",
            "S80",
            "S90",
            "V40",
            "V40 Cross Country",
            "V50",
            "V60",
            "V70",
            "V90",
            "XC60",
            "XC70",
            "XC90"),"name"=>
    "Volvo",
),
array(
    "models"
    =>
        array(
            "Choisir un modèle",
            "Izis"),"name"=>
    "Wallyscar")
);
foreach ($array as $value)
{
    $mark=new Mark();
    $mark->setName($value["name"]);
    $em->persist($mark);
    $em->flush();
    $em->refresh($mark);
    foreach ($value["models"] as $valueModel)
    {
        $model=new Model();
        $model->setName($valueModel);
        $model->setMark($mark);

        $em->persist($model);
        $em->flush();
        $em->refresh($model);
    }

}
return new Response("helle");
    }

public function removeMarksAction(){

    $em = $this->getDoctrine()->getManager();
    $auto= $em->getRepository('AdminBundle:Automobile')->findAll();
    foreach ($auto as $model)
    {
        $em->remove($model);
        $em->flush();
    }
    $models = $em->getRepository('AdminBundle:Model')->findAll();
    foreach ($models as $model)
    {
        $em->remove($model);
        $em->flush();
    }
    $marks = $em->getRepository('AdminBundle:Mark')->findAll();
    foreach ($marks as $model)
    {
        $em->remove($model);
        $em->flush();
    }
return new Response("helle");
}}