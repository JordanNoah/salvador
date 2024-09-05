<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin-related strings
$string['pluginname'] = 'DigitalTA';

// Settings
$string['config:issuerid'] = 'OAuth-service voor Google Meet-integratie';

// General
$string['general:platform_name']       = 'Lerarenacademie';
$string['general:required']            = '<span style="color: red;">*</span> Elementen gemarkeerd met een rood sterretje zijn verplicht.';
$string['general:no_elements']         = 'Geen elementen om te tonen';
$string['general:see_more']            = 'Meer zien';
$string['general:learn_more']          = 'Meer informatie';
$string['general:video_not_supported'] = 'Uw browser ondersteunt de videotag niet.';
$string['general:date_timeago']        = '{$a} geleden';
$string['general:date_justnow']        = 'Zojuist';
$string['general:avatar_alt']          = 'Avatar gebruiker';
$string['general:lang_pluri']          = 'Meertalig';

// Concepts / terms
$string['concept:experience']    = 'Ervaring';
$string['concept:experiences']   = 'Ervaringen';
$string['concept:case']          = 'Zaak';
$string['concept:cases']         = 'Gevallen';
$string['concept:resource']      = 'Bron';
$string['concept:resources']     = 'Bronnen';
$string['concept:user']          = 'Gebruiker';
$string['concept:users']         = 'Gebruikers';
$string['concept:theme']         = 'Thema';
$string['concept:themes']        = 'Thema\'s';
$string['concept:tag']           = 'Label';
$string['concept:tags']          = 'Tags';
$string['concept:themestags']    = 'Thema\'s & Tags';
$string['concept:language']      = 'Taal';
$string['concept:reflection']    = 'Reflectie';
$string['concept:tutor']         = 'Docent';
$string['concept:tutors']        = 'Docenten';
$string['concept:mentor']        = 'Mentor';
$string['concept:mentors']       = 'Mentoren';
$string['concept:tutorsmentors'] = 'Docenten en mentoren';
$string['concept:introduction']  = 'Inleiding';


// Concepts / terms - Definitions
$string['concept:experience:definition'] = 'Een ervaring is een echte onderwijspraktijk die gedeeld wordt door een leerkracht. Het kan een lesplan zijn, een klassikale activiteit, een reflectie of een andere lesgerelateerde inhoud.';
$string['concept:case:definition']       = 'Een casus is een gedetailleerde beschrijving van een echte onderwijservaring. Het omvat de context, het probleem, de ondernomen acties, de resultaten en de reflecties van de leerkracht.';
$string['concept:resource:definition']   = 'Een bron is onderwijsgerelateerd materiaal dat kan worden gebruikt ter ondersteuning van een les, een activiteit of een reflectie. Het kan een boek, een video, een website of een ander soort inhoud zijn.';
$string['concept:theme:definition']      = 'Een thema is een breed onderwerp dat relevant is voor onderwijs en opvoeding. Het kan gebruikt worden om ervaringen, gevallen en bronnen te categoriseren.';
$string['concept:tag:definition']        = 'Een tag is een trefwoord of label dat wordt gebruikt om de inhoud van een ervaring, een case of een bron te beschrijven. Het kan worden gebruikt om zoeken en ontdekken te vergemakkelijken.';

// Concepts / terms - Tutorials
$string['concept:experience:tutorial_intro'] = 'Ervaringen vormen het hart van de Teacher Academy. Het zijn echte onderwijspraktijken die worden gedeeld door leerkrachten zoals jij. Je kunt ervaringen onderzoeken, erover nadenken en leren van de inzichten en ervaringen van je collega\'s.';
$string['concept:experience:tutorial_steps'] = '<ol>
    <li>Voeg een titel toe aan je ervaring.</li>
    <li>Vul de verplichte velden in (taal, afbeelding, zichtbaarheid, thema\'s).</li>
    <li>Voer een korte beschrijving van je ervaring in.</li>
    <li>Klik op de knop "Posten" om je ervaring te publiceren.</li>
</ol>';

// Visibility
$string['visibility:public']  = 'Openbaar';
$string['visibility:private'] = 'Privé';

// Actions
$string['actions:edit']   = 'Bewerk';
$string['actions:lock']   = 'Slot';
$string['actions:unlock'] = 'Ontgrendel';
$string['actions:delete'] = 'Verwijder';
$string['actions:import'] = 'Importeren';
$string['actions:export'] = 'Exporteer';

// Reactions
$string['reactions:like']            = 'Zoals';
$string['reactions:dislike']         = 'Ik vind  niet leuk';
$string['reactions:comments']        = 'Reacties';
$string['reactions:add_new_comment'] = 'Nieuw commentaar toevoegen';
$string['reactions:report']          = 'Rapporteer';

// Teacher Academy
$string['teacheracademy:header']      = $string['general:platform_name'];
$string['teacheracademy:title']       = $string['general:platform_name'];
$string['teacheracademy:description'] = '<p>Welkom bij <span class="digitalta-highlighted-upper">Teacher Academy</span>, uw gezamenlijke ruimte voor professionele groei! Hier kun je <span class="digitalta-highlighted">ervaringen in de klas uit de echte wereld</span> verkennen, in contact komen met <span class="digitalta-highlighted">docenten</span>, toegang krijgen tot een schat aan <span class="digitalta-highlighted">lesmateriaal</span>, stel <span class="digitalta-highlighted">vragen</span> en laat u inspireren door diverse <span class="digitalta-highlighted">lesmethoden</span>. Begin je reis door je aan te sluiten bij onze levendige gemeenschap en geef de volgende generatie leerlingen de kans om te leren. Laten we samen het onderwijs veranderen!';

// Teacher Academy - Actions
$string['teacheracademy:actions:question']    = '{$a}, wat wil je vandaag doen?';
$string['teacheracademy:actions:explore']     = 'Ervaringen verkennen';
$string['teacheracademy:actions:ask']         = 'Stel een vraag';
$string['teacheracademy:actions:share']       = 'Deel uw ervaring';
$string['teacheracademy:actions:connect']     = 'In contact komen met experts';
$string['teacheracademy:actions:discover']    = 'Ontdek bronnen';
$string['teacheracademy:actions:getinspired'] = 'Laat je inspireren door echte gevallen';
$string['teacheracademy:actions:create']      = 'Een nieuwe zaak aanmaken';

// Teacher Academy - Actions - Add modal
$string['teacheracademy:actions:ask:description']       = 'Een vraag stellen over een bepaalde onderwijservaring is een goede manier om je reflectieproces op gang te brengen. Op die manier krijg je feedback van andere leerkrachten en experts en kun je leren van hun ervaringen.';
$string['teacheracademy:actions:ask:title']             = 'Begin met het invullen van je <span class="digitalta-highlighted">vraag</span> hieronder:';
$string['teacheracademy:actions:ask:title:placeholder'] = 'Voer uw vraag in...';
$string['teacheracademy:actions:ask:picture']           = 'Upload een afbeelding die je vraag weergeeft. Deze afbeelding is optioneel en dient alleen als decoratie. Extra afbeeldingen kunnen worden toegevoegd aan de vraagbeschrijving.';
$string['teacheracademy:actions:ask:visibility']        = 'Wil je dat je vraag <span class="digitalta-highlighted">public</span> of <span class="digitalta-highlighted">private</span> is?';
$string['teacheracademy:actions:ask:language']          = 'Selecteer de <span class="digitalta-highlighted">taal</span> van je vraag:';
$string['teacheracademy:actions:ask:themes']            = 'Selecteer de <span class="digitalta-highlighted">thema\'s</span> die je vraag het beste beschrijven:';
$string['teacheracademy:actions:ask:tags']              = 'Voeg <span class="digitalta-highlighted">tags</span> toe aan je vraag:';

$string['teacheracademy:actions:share:description']       = 'Het delen van je ervaring is een krachtige manier om na te denken over je onderwijspraktijk, van anderen te leren en collega-onderwijzers te inspireren.';
$string['teacheracademy:actions:share:title']             = 'Begin met het invoeren van een betekenisvolle <span class="digitalta-highlighted">titel</span> voor je ervaring:';
$string['teacheracademy:actions:share:title:placeholder'] = 'Voer een titel in...';
$string['teacheracademy:actions:share:picture']           = 'Upload een foto die je ervaring weergeeft. Deze afbeelding is optioneel en dient alleen als decoratie. Extra afbeeldingen kunnen worden toegevoegd aan de beschrijving van de ervaring.';
$string['teacheracademy:actions:share:visibility']        = 'Wil je dat je ervaring <span class="digitalta-highlighted">public</span> of <span class="digitalta-highlighted">private</span> is?';
$string['teacheracademy:actions:share:language']          = 'Selecteer de <span class="digitalta-highlighted">taal</span> van je ervaring:';
$string['teacheracademy:actions:share:themes']            = 'Selecteer de <span class="digitalta-highlighted">thema\'s</span> die jouw ervaring het beste beschrijven:';
$string['teacheracademy:actions:share:tags']              = 'Voeg <span class="digitalta-highlighted">tags</span> toe aan je ervaring:';

// Themes & Tags
$string['themestags:title']            = $string['concept:themestags'];
$string['themestags:header']           = $string['concept:themestags'];
$string['themestags:description']      = '<p>Verken onze <span class="digitalta-highlighted">thema\'s</span> en <span class="digitalta-highlighted">tags</span> om de meest relevante <span class="digitalta-highlighted">ervaringen</span>, <span class="digitalta-highlighted">cases</span>, en <span class="digitalta-highlighted">bronnen</span> gedeeld door onze gemeenschap.</p>';
$string['themestags:view:description'] = '<p>Ontdek de meest relevante <span class="digitalta-highlighted">ervaringen</span>, <span class="digitalta-highlighted">cases</span>en <span class="digitalta-highlighted">bronnen</span> gedeeld door onze gemeenschap over <span class="digitalta-highlighted-upper">{$a}</span>.</p>';
$string['themestags:invalidthemetag']  = 'Ongeldige tag of thema';

// Experiences
$string['experiences:title']       = $string['concept:experiences'];
$string['experiences:header']      = $string['concept:experiences'];
$string['experiences:description'] = '<p>Ontdek een breed scala aan <span class="digitalta-highlighted">ervaringen</span> gedeeld door leerkrachten van over de hele wereld. Je kunt leren van hun inzichten, nadenken over hun praktijken en geïnspireerd raken door hun verhalen. Je kunt ook met hen in contact komen, vragen stellen en je eigen ervaringen delen om bij te dragen aan de community.</p>';

// Experience - Actions
$string['experience:featured']       = 'Aanbevolen';
$string['experience:lock']           = 'Ervaring met sloten';
$string['experience:lock:confirm']   = 'Weet je zeker dat je deze ervaring wilt afsluiten?';
$string['experience:unlock']         = 'Ervaring ontgrendelen';
$string['experience:unlock:confirm'] = 'Weet je zeker dat je deze ervaring wilt vrijspelen?';
$string['experience:delete']         = 'Ervaring verwijderen';
$string['experience:delete:confirm'] = 'Weet je zeker dat je deze ervaring wilt verwijderen?';
$string['experience:delete:success'] = 'Ervaring succesvol verwijderd';
$string['experience:export']         = 'Exporteer ervaring naar case';

// Experience - Tutoring
$string['experience:tutoring:title']       = 'Docenten';
$string['experience:tutoring:description'] = 'Tutoren zijn een geweldige manier om persoonlijke ondersteuning en begeleiding te krijgen bij je onderwijspraktijk. Je kunt bijles aanvragen bij ervaren docenten die je kunnen helpen om na te denken over je ervaringen, feedback kunnen geven en waardevolle inzichten kunnen bieden.';
$string['experience:tutoring:see_all']     = 'Bekijk alle docenten';
$string['experience:tutoring:placeholder'] = 'Docenten of mentoren zoeken...';
$string['experience:tutoring:notutors']    = 'Er zijn geen mentoren of begeleiders toegewezen aan deze ervaring.';

// Experience - Reflection
$string['experience:reflection:title']                = 'Nadenken over je ervaring';
$string['experience:reflection:description']          = 'Je begon je zelfreflectieproces met het beschrijven van de context van je ervaring. Nu kun je verder gaan door te beschrijven wat je deed, waarom je het deed en wat er gebeurde toen je het uitprobeerde. Je kunt ook nadenken over wat je hebt geleerd, welke impact het had en wat je nu moet doen. Je kunt ook alle bronnen koppelen die je tijdens dit proces hebt gebruikt.';
$string['experience:reflection:edit']                 = 'Reflecteren';
$string['experience:reflection:what']                 = 'Wat?';
$string['experience:reflection:what:description']     = 'Beschrijf kort de <span class="digitalta-highlighted">context</span> van je ervaring. Beschrijf wat er in je klas gebeurt? Wat is het probleem? Wat dacht/voelde je?';
$string['experience:reflection:so_what']              = 'En dan?';
$string['experience:reflection:so_what:description']  = 'Hoe heb je <span class="digitalta-highlighted">hier meer over ontdekt</span>? Collega\'s, literatuur, docent... Wie heb je gevraagd? Wat heb je gelezen?';
$string['experience:reflection:now_what']             = 'Wat nu?';
$string['experience:reflection:now_what:description'] = 'Wat heb je gedaan, waarom heb je het gedaan en wat gebeurde er toen je het uitprobeerde? Wat heb je <span class="digitalta-highlighted">geleerd</span>, welke impact had het en wat moet je nu doen?';
$string['experience:reflection:empty']                = 'Dit deel van het reflectieproces is nog niet afgerond.';

// Experience - Resources
$string['experience:resources:link']             = 'Link bronnen';
$string['experience:resources:link:description'] = 'Je kunt bronnen uit het archief koppelen aan je ervaring.';
$string['experience:resources:unlink']           = 'Bron ontkoppelen';
$string['experience:resources:unlink:confirm']   = 'Weet je zeker dat je deze bron wilt loskoppelen van de ervaring?';
$string['experience:resources:add_new']          = 'Een nieuwe bron toevoegen';
$string['experience:resources:description']      = 'Waarom heb je deze bron gekozen? Hoe heb je het gebruikt? Wat heb je ervan geleerd?';
$string['experience:resources:empty']            = 'Er zijn nog geen bronnen gekoppeld aan deze ervaring.';
$string['experience:resources:visit']            = 'Bezoek bron';

// Cases
$string['cases:title']       = $string['concept:cases'];
$string['cases:header']      = $string['concept:cases'];
$string['cases:description'] = '<p>Bekijk een verzameling <span class="digitalta-highlighted">cases</span> gedeeld door leerkrachten van over de hele wereld. Elke casus is een gedetailleerde beschrijving van een echte onderwijservaring, inclusief de context, het probleem, de ondernomen acties, de resultaten en de reflecties van de leraar.</p>';

// Cases - Management
$string['cases:manage']                 = 'Casussen beheren';
$string['cases:manage:add']             = 'Een nieuwe case toevoegen';
$string['cases:manage:add:button']      = 'Voeg  toe';
$string['cases:manage:add:placeholder'] = 'Voer de titel van de zaak in...';
$string['cases:manage:title']           = 'Titel';
$string['cases:manage:description']     = 'Beschrijving';
$string['cases:manage:themes']          = $string['concept:themes'];
$string['cases:manage:tags']            = $string['concept:tags'];
$string['cases:manage:language']        = $string['concept:language'];

// Case - Actions
$string['case:delete']         = 'Geval verwijderen';
$string['case:delete:confirm'] = 'Weet je zeker dat je deze zaak wilt verwijderen?';
$string['case:delete:success'] = 'Zaak succesvol verwijderd';
$string['case:save']           = 'Koffer opslaan';
$string['case:save:confirm']   = 'Weet je zeker dat je deze zaak wilt redden?';

// Case - Sections
$string['case:section:add']            = 'Sectie toevoegen';
$string['case:section:delete']         = 'Sectie verwijderen';
$string['case:section:delete:confirm'] = 'Weet je zeker dat je deze sectie wilt verwijderen?';

// Resources
$string['resources:title']       = $string['concept:resources'];
$string['resources:header']      = $string['concept:resources'];
$string['resources:description'] = '<p>Ontdek een breed scala aan <span class="digitalta-highlighted">bronnen</span> gedeeld door leerkrachten van over de hele wereld. Je kunt boeken, video\'s, websites en ander lesmateriaal vinden die je kunnen helpen je lespraktijk te verbeteren, je leerlingen te betrekken en je lessen te inspireren. Je kunt ook je eigen bronnen delen om bij te dragen aan de community.</p>';

// Resources - Management
$string['resources:manage:add']                     = 'Bron toevoegen';
$string['resources:manage:add:description']         = 'Je kunt een nieuwe bron aan het archief toevoegen door de verplichte velden hieronder in te vullen.';
$string['resources:manage:name']                    = 'Naam';
$string['resources:manage:name:placeholder']        = 'Voer de naam van de bron in...';
$string['resources:manage:path']                    = 'Link';
$string['resources:manage:path:placeholder']        = 'Voer de link naar de bron in...';
$string['resources:manage:description']             = 'Beschrijving';
$string['resources:manage:description:placeholder'] = 'Voer een korte beschrijving van de bron in...';
$string['resources:manage:themes']                  = $string['concept:themes'];
$string['resources:manage:tags']                    = $string['concept:tags'];
$string['resources:manage:type']                    = 'Type';
$string['resources:manage:language']                = $string['concept:language'];

// Resource - Actions
$string['resource:delete']         = 'Bron verwijderen';
$string['resource:delete:confirm'] = 'Weet je zeker dat je deze bron wilt verwijderen?';
$string['resource:delete:success'] = 'Bron succesvol verwijderd';

// Tutors
$string['tutors:title']       = $string['concept:tutorsmentors'];
$string['tutors:header']      = $string['concept:tutorsmentors'];
$string['tutors:description'] = '<p>Kom in contact met ervaren <span class="digitalta-highlighted">docenten</span> en <span class="digitalta-highlighted">mentoren</span> die je kunnen helpen om na te denken over je onderwijspraktijk, feedback kunnen geven en waardevolle inzichten kunnen bieden. Je kunt bijles aanvragen, vragen stellen en persoonlijke ondersteuning krijgen om je onderwijsvaardigheden te verbeteren en je leerlingen meer mogelijkheden te geven.</p>';

// Profile
$string['profile:title']  = 'Profiel';
$string['profile:header'] = 'Profiel';

// Elements - Components
$string['component:experience'] = $string['concept:experience'];
$string['component:case']       = $string['concept:case'];
$string['component:resource']   = $string['concept:resource'];
$string['component:user']       = $string['concept:user'];

// Elements - Modifiers
$string['modifier:theme'] = $string['concept:theme'];
$string['modifier:tag']   = $string['concept:tag'];

// Elements - Themes
$string['theme:digital_technology']                         = 'Digitale technologie';
$string['theme:classroom_management']                       = 'Klassenmanagement';
$string['theme:communication_and_relationship_building']    = 'Communicatie en het opbouwen van relaties';
$string['theme:diversity_and_inclusion']                    = 'Diversiteit en inclusie';
$string['theme:professional_collaboration_and_development'] = 'Professionele samenwerking en ontwikkeling';
$string['theme:school_culture']                             = 'Schoolcultuur';
$string['theme:curriculum_planning_and_development']        = 'Curriculumplanning en -ontwikkeling';
$string['theme:others']                                     = 'Anderen';

// Elements - Resource types
$string['resource_type:other']       = 'Andere';
$string['resource_type:book']        = 'Boek';
$string['resource_type:chart']       = 'Kaart';
$string['resource_type:comic']       = 'Strip';
$string['resource_type:diary']       = 'Dagboek';
$string['resource_type:field_notes'] = 'Veldnotities';
$string['resource_type:image']       = 'Afbeelding';
$string['resource_type:interview']   = 'Interview';
$string['resource_type:journal']     = 'Tijdschrift';
$string['resource_type:magazine']    = 'Tijdschrift';
$string['resource_type:map']         = 'Kaart';
$string['resource_type:music']       = 'Muziek';
$string['resource_type:newspaper']   = 'Krant';
$string['resource_type:photograph']  = 'Foto';
$string['resource_type:podcast']     = 'Podcast';
$string['resource_type:report']      = 'Rapporteer';
$string['resource_type:study_case']  = 'Case studie';
$string['resource_type:video']       = 'Video';
$string['resource_type:website']     = 'Website';

// Elements - Resource formats
$string['resource_format:none']     = 'Geen';
$string['resource_format:link']     = 'Link';
$string['resource_format:image']    = 'Afbeelding';
$string['resource_format:video']    = 'Video';
$string['resource_format:document'] = 'Document';

// Elements - Section groups
$string['section_group:general']  = 'Algemeen';
$string['section_group:what']     = 'Wat?';
$string['section_group:so_what']  = 'En dan?';
$string['section_group:now_what'] = 'Wat nu?';

// Elements - Section types
$string['section_type:text'] = 'Tekst';














// Tutor Repository - MyTutoring
$string['tutor_searchbar_placeholder'] = 'Zoek een bijlesgever...';

// Filters
$string['filter_themes_label'] = 'Thema\'s';
$string['filter_themes_placeholder'] = 'Selecteer een thema...';
$string['filter_tags_label'] = 'Tags';
$string['filter_tags_placeholder'] = 'Selecteer een tag...';
$string['filter_language_label'] = 'Taal';
$string['filter_language_placeholder'] = 'Selecteer een taal...';

// Tutoring
$string['tutoring:request'] = 'Aanvraag bijles';
$string['tutoring:title'] = 'MIJN BIJLESSEN';
$string['tutoring:back_to_chat'] = 'Terug naar chat';
$string['tutoring:tutor_comments'] = 'Opmerkingen mentor';
$string['tutoring:open_chats'] = 'Open chats';
$string['tutoring:view_tooltip'] = 'Bekijk tooltip';
$string['tutoring:videocallbutton'] = 'Google Ontmoet gesprek starten';
$string['tutoring:joinvideocall'] = 'Neem deel aan Google Ontmoet gesprek';
$string['tutoring:closevideocall'] = 'Bijna raak';
$string['tutoring:at_university'] = 'Leraar bij';
