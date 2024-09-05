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
$string['config:issuerid'] = 'Usługa OAuth dla integracji z Google Meet';

// General
$string['general:platform_name']       = 'Akademia nauczyciela';
$string['general:required']            = '<span style="color: red;">*</span> Elementy oznaczone czerwoną gwiazdką są wymagane.';
$string['general:no_elements']         = 'Brak elementów do wyświetlenia';
$string['general:see_more']            = 'Zobacz więcej';
$string['general:learn_more']          = 'Dowiedz się więcej';
$string['general:video_not_supported'] = 'Twoja przeglądarka nie obsługuje tagu wideo.';
$string['general:date_timeago']        = '{$a} temu';
$string['general:date_justnow']        = 'Właśnie teraz';
$string['general:avatar_alt']          = 'Awatar użytkownika';
$string['general:lang_pluri']          = 'Wielojęzyczny';

// Concepts / terms
$string['concept:experience']    = 'Doświadczenie';
$string['concept:experiences']   = 'Doświadczenia';
$string['concept:case']          = 'Przypadek';
$string['concept:cases']         = 'Przypadki';
$string['concept:resource']      = 'Zasoby';
$string['concept:resources']     = 'Zasoby';
$string['concept:user']          = 'Użytkownik';
$string['concept:users']         = 'Użytkownicy';
$string['concept:theme']         = 'Temat';
$string['concept:themes']        = 'Tematy';
$string['concept:tag']           = 'Tag';
$string['concept:tags']          = 'Tagi';
$string['concept:themestags']    = 'Motywy i tagi';
$string['concept:language']      = 'Język';
$string['concept:reflection']    = 'Refleksja';
$string['concept:tutor']         = 'Nauczyciel';
$string['concept:tutors']        = 'Nauczyciele';
$string['concept:mentor']        = 'Mentor';
$string['concept:mentors']       = 'Mentorzy';
$string['concept:tutorsmentors'] = 'Nauczyciele i mentorzy';
$string['concept:introduction']  = 'Wprowadzenie';


// Concepts / terms - Definitions
$string['concept:experience:definition'] = 'Doświadczenie to rzeczywista praktyka nauczania, którą dzieli się nauczyciel. Może to być plan lekcji, aktywność w klasie, refleksja lub dowolna inna treść związana z nauczaniem.';
$string['concept:case:definition']       = 'Przypadek to szczegółowy opis rzeczywistego doświadczenia w nauczaniu. Obejmuje on kontekst, problem, podjęte działania, wyniki i refleksje nauczyciela.';
$string['concept:resource:definition']   = 'Zasób to materiał związany z nauczaniem, który może być wykorzystany do wsparcia lekcji, aktywności lub refleksji. Może to być książka, film, strona internetowa lub inny rodzaj treści.';
$string['concept:theme:definition']      = 'Temat jest szerokim zagadnieniem lub tematem, który jest istotny dla nauczania i edukacji. Może być używany do kategoryzowania doświadczeń, przypadków i zasobów.';
$string['concept:tag:definition']        = 'Tag to słowo kluczowe lub etykieta używana do opisania zawartości doświadczenia, przypadku lub zasobu. Może być wykorzystywany do ułatwiania wyszukiwania i odnajdywania.';

// Concepts / terms - Tutorials
$string['concept:experience:tutorial_intro'] = 'Doświadczenia są sercem Teacher Academy. Są to rzeczywiste praktyki nauczania, którymi dzielą się nauczyciele tacy jak Ty. Możesz odkrywać doświadczenia, zastanawiać się nad nimi i uczyć się na podstawie spostrzeżeń i doświadczeń swoich rówieśników.';
$string['concept:experience:tutorial_steps'] = '<ol>
    <li>Dodaj tytuł do swojego doświadczenia.</li>
    <li>Wypełnij wymagane pola (język, zdjęcie, widoczność, motywy).</li>
    <li>Wprowadź krótki opis swojego doświadczenia.</li>
    <li>Kliknij przycisk "Opublikuj", aby opublikować swoje doświadczenie.</li>
</ol>';

// Visibility
$string['visibility:public']  = 'Publiczny';
$string['visibility:private'] = 'Prywatny';

// Actions
$string['actions:edit']   = 'Edytuj';
$string['actions:lock']   = 'Blokada';
$string['actions:unlock'] = 'Odblokowanie';
$string['actions:delete'] = 'Usuń';
$string['actions:import'] = 'Import';
$string['actions:export'] = 'Eksport';

// Reactions
$string['reactions:like']            = 'Jak';
$string['reactions:dislike']         = 'Nie lubię';
$string['reactions:comments']        = 'Komentarze';
$string['reactions:add_new_comment'] = 'Dodaj nowy komentarz';
$string['reactions:report']          = 'Raport';

// Teacher Academy
$string['teacheracademy:header']      = $string['general:platform_name'];
$string['teacheracademy:title']       = $string['general:platform_name'];
$string['teacheracademy:description'] = '<p>Witamy w <span class="digitalta-highlighted-upper">Teacher Academy</span>, przestrzeni współpracy na rzecz rozwoju zawodowego! Tutaj możesz odkrywać <span class="digitalta-highlighted">prawdziwe doświadczenia w klasie</span>, łączyć się z <span class="digitalta-highlighted">wykładowcami</span>, uzyskać dostęp do bogactwa <span class="digitalta-highlighted">zasobów dydaktycznych</span>, zadawać <span class="digitalta-highlighted">pytania</span> i czerpać inspirację z różnorodnych <span class="digitalta-highlighted">praktyk dydaktycznych</span>. Rozpocznij swoją podróż, angażując się w naszą tętniącą życiem społeczność i wspierając kolejne pokolenie uczniów. Przekształćmy edukację razem! </p>';

// Teacher Academy - Actions
$string['teacheracademy:actions:question']    = '{$a}, co chcesz dzisiaj robić?';
$string['teacheracademy:actions:explore']     = 'Poznaj doświadczenia';
$string['teacheracademy:actions:ask']         = 'Zadaj pytanie';
$string['teacheracademy:actions:share']       = 'Podziel się swoim doświadczeniem';
$string['teacheracademy:actions:connect']     = 'Połącz się z ekspertami';
$string['teacheracademy:actions:discover']    = 'Odkryj zasoby';
$string['teacheracademy:actions:getinspired'] = 'Zainspiruj się prawdziwymi przypadkami';
$string['teacheracademy:actions:create']      = 'Utwórz nową sprawę';

// Teacher Academy - Actions - Add modal
$string['teacheracademy:actions:ask:description']       = 'Zadanie pytania dotyczącego konkretnego doświadczenia w nauczaniu to świetny sposób na rozpoczęcie procesu refleksji. W ten sposób będziesz mógł uzyskać informacje zwrotne od innych nauczycieli i ekspertów oraz uczyć się na ich doświadczeniach.';
$string['teacheracademy:actions:ask:title']             = 'Zacznij od wpisania swojego <span class="digitalta-highlighted">pytania</span> poniżej:';
$string['teacheracademy:actions:ask:title:placeholder'] = 'Wpisz swoje pytanie...';
$string['teacheracademy:actions:ask:picture']           = 'Prześlij zdjęcie, które odzwierciedla Twoje pytanie. Ten obraz jest opcjonalny i będzie służył jedynie jako dekoracja. Do opisu pytania można dodać dodatkowe obrazy.';
$string['teacheracademy:actions:ask:visibility']        = 'Czy chcesz, aby Twoje pytanie było <span class="digitalta-highlighted">publiczne</span> czy <span class="digitalta-highlighted">prywatne</span>?';
$string['teacheracademy:actions:ask:language']          = 'Wybierz <span class="digitalta-highlighted">język</span> swojego pytania:';
$string['teacheracademy:actions:ask:themes']            = 'Wybierz <span class="digitalta-highlighted">tematy</span>, które najlepiej opisują Twoje pytanie:';
$string['teacheracademy:actions:ask:tags']              = 'Dodaj <span class="digitalta-highlighted">tagi</span> do swojego pytania:';

$string['teacheracademy:actions:share:description']       = 'Dzielenie się swoimi doświadczeniami to skuteczny sposób na zastanowienie się nad swoją praktyką nauczania, uczenie się od innych i inspirowanie innych nauczycieli.';
$string['teacheracademy:actions:share:title']             = 'Zacznij od wprowadzenia znaczącego <span class="digitalta-highlighted">tytułu</span> dla swojego doświadczenia:';
$string['teacheracademy:actions:share:title:placeholder'] = 'Wprowadź tytuł...';
$string['teacheracademy:actions:share:picture']           = 'Prześlij zdjęcie, które odzwierciedla Twoje doświadczenie. Ten obraz jest opcjonalny i będzie służył jedynie jako dekoracja. Do opisu doświadczenia można dodać dodatkowe zdjęcia.';
$string['teacheracademy:actions:share:visibility']        = 'Czy chcesz, aby Twoje doświadczenie było <span class="digitalta-highlighted">publiczne</span> czy <span class="digitalta-highlighted">prywatne</span>?';
$string['teacheracademy:actions:share:language']          = 'Wybierz <span class="digitalta-highlighted">język</span> swojego doświadczenia:';
$string['teacheracademy:actions:share:themes']            = 'Wybierz <span class="digitalta-highlighted">tematy</span>, które najlepiej opisują Twoje doświadczenie:';
$string['teacheracademy:actions:share:tags']              = 'Dodaj <span class="digitalta-highlighted">tagi</span> do swojego doświadczenia:';

// Themes & Tags
$string['themestags:title']            = $string['concept:themestags'];
$string['themestags:header']           = $string['concept:themestags'];
$string['themestags:description']      = '<p>Zapoznaj się z naszymi <span class="digitalta-highlighted">tematami</span> i <span class="digitalta-highlighted">tagami</span>, aby znaleźć najistotniejsze <span class="digitalta-highlighted">doświadczenia</span>, <span class="digitalta-highlighted">przypadki</span> i <span class="digitalta-highlighted">zasoby</span> udostępnione przez naszą społeczność.</p>';
$string['themestags:view:description'] = '<p>Odkryj najbardziej istotne <span class="digitalta-highlighted">doświadczenia</span>, <span class="digitalta-highlighted">przypadki</span>i <span class="digitalta-highlighted">zasoby</span> udostępnione przez naszą społeczność na temat <span class="digitalta-highlighted-upper">{$a}</span>.</p>';
$string['themestags:invalidthemetag']  = 'Nieprawidłowy tag lub motyw';

// Experiences
$string['experiences:title']       = $string['concept:experiences'];
$string['experiences:header']      = $string['concept:experiences'];
$string['experiences:description'] = '<p>Zapoznaj się z szeroką gamą <span class="digitalta-highlighted">doświadczeń</span> dzielonych przez nauczycieli z całego świata. Możesz uczyć się na podstawie ich spostrzeżeń, zastanawiać się nad ich praktykami i inspirować się ich historiami. Możesz również łączyć się z nimi, zadawać pytania i dzielić się własnymi doświadczeniami, aby wnieść swój wkład w społeczność.</p>';

// Experience - Actions
$string['experience:featured']       = 'Polecane';
$string['experience:lock']           = 'Doświadczenie z blokadą';
$string['experience:lock:confirm']   = 'Czy na pewno chcesz zablokować to doświadczenie?';
$string['experience:unlock']         = 'Odblokuj doświadczenie';
$string['experience:unlock:confirm'] = 'Czy na pewno chcesz odblokować to doświadczenie?';
$string['experience:delete']         = 'Usuń doświadczenie';
$string['experience:delete:confirm'] = 'Czy na pewno chcesz usunąć to doświadczenie?';
$string['experience:delete:success'] = 'Doświadczenie zostało pomyślnie usunięte';
$string['experience:export']         = 'Doświadczenie w eksporcie';

// Experience - Tutoring
$string['experience:tutoring:title']       = 'Nauczyciele';
$string['experience:tutoring:description'] = 'Tutorzy to świetny sposób na uzyskanie spersonalizowanego wsparcia i wskazówek dotyczących praktyki nauczania. Możesz poprosić o sesje korepetycji z doświadczonymi nauczycielami, którzy pomogą ci zastanowić się nad swoimi doświadczeniami, udzielą informacji zwrotnych i zaoferują cenne spostrzeżenia.';
$string['experience:tutoring:see_all']     = 'Zobacz wszystkich korepetytorów';
$string['experience:tutoring:placeholder'] = 'Szukaj korepetytorów lub mentorów...';
$string['experience:tutoring:notutors']    = 'Do tego doświadczenia nie przydzielono opiekunów ani mentorów.';

// Experience - Reflection
$string['experience:reflection:title']                = 'Refleksja nad własnym doświadczeniem';
$string['experience:reflection:description']          = 'Rozpocząłeś proces autorefleksji, opisując kontekst swojego doświadczenia. Teraz możesz kontynuować, opisując, co zrobiłeś, dlaczego to zrobiłeś i co się stało, gdy to wypróbowałeś. Możesz także zastanowić się nad tym, czego się nauczyłeś, jaki to miało wpływ i co powinieneś zrobić dalej. Możesz także połączyć wszelkie zasoby, z których korzystałeś podczas tego procesu.';
$string['experience:reflection:edit']                 = 'Odbicie';
$string['experience:reflection:what']                 = 'Co?';
$string['experience:reflection:what:description']     = 'Krótko opisz <span class="digitalta-highlighted">kontekst</span> swojego doświadczenia. Opisz, co dzieje się w Twojej klasie? O co chodzi? Co wtedy myślałeś/czułeś?';
$string['experience:reflection:so_what']              = 'I co z tego?';
$string['experience:reflection:so_what:description']  = 'W jaki sposób <span class="digitalta-highlighted">dowiedziałeś się więcej</span> na ten temat? Koledzy, literatura, korepetytor... Kogo zapytałeś? Co przeczytałeś?';
$string['experience:reflection:now_what']             = 'Co teraz?';
$string['experience:reflection:now_what:description'] = 'Co zrobiłeś, dlaczego to zrobiłeś i co się stało, gdy to wypróbowałeś? Czego się <span class="digitalta-highlighted">nauczyłeś</span>, jaki to miało wpływ i co powinieneś zrobić dalej?';
$string['experience:reflection:empty']                = 'Ta część procesu refleksji nie została jeszcze podjęta.';

// Experience - Resources
$string['experience:resources:link']             = 'Zasoby linków';
$string['experience:resources:link:description'] = 'Możesz połączyć zasoby z repozytorium ze swoim doświadczeniem.';
$string['experience:resources:unlink']           = 'Odłącz zasób';
$string['experience:resources:unlink:confirm']   = 'Czy na pewno chcesz odłączyć ten zasób od doświadczenia?';
$string['experience:resources:add_new']          = 'Dodaj nowy zasób';
$string['experience:resources:description']      = 'Dlaczego wybrałeś ten zasób? Jak z niego korzystałeś? Czego się dzięki temu nauczyłeś?';
$string['experience:resources:empty']            = 'Brak zasobów związanych z tym doświadczeniem.';
$string['experience:resources:visit']            = 'Odwiedź zasoby';

// Cases
$string['cases:title']       = $string['concept:cases'];
$string['cases:header']      = $string['concept:cases'];
$string['cases:description'] = '<p>Zapoznaj się z kolekcją <span class="digitalta-highlighted">przypadków</span> udostępnionych przez nauczycieli z całego świata. Każdy przypadek jest szczegółowym opisem rzeczywistego doświadczenia w nauczaniu, w tym kontekstu, problemu, podjętych działań, wyników i refleksji nauczyciela.';

// Cases - Management
$string['cases:manage']                 = 'Zarządzanie sprawami';
$string['cases:manage:add']             = 'Dodaj nowy przypadek';
$string['cases:manage:add:button']      = 'Dodaj';
$string['cases:manage:add:placeholder'] = 'Wprowadź tytuł sprawy...';
$string['cases:manage:title']           = 'Tytuł';
$string['cases:manage:description']     = 'Opis';
$string['cases:manage:themes']          = $string['concept:themes'];
$string['cases:manage:tags']            = $string['concept:tags'];
$string['cases:manage:language']        = $string['concept:language'];

// Case - Actions
$string['case:delete']         = 'Usuń obudowę';
$string['case:delete:confirm'] = 'Czy na pewno chcesz usunąć tę sprawę?';
$string['case:delete:success'] = 'Sprawa została pomyślnie usunięta';
$string['case:save']           = 'Zapisz sprawę';
$string['case:save:confirm']   = 'Czy na pewno chcesz uratować tę sprawę?';

// Case - Sections
$string['case:section:add']            = 'Dodaj sekcję';
$string['case:section:delete']         = 'Usuń sekcję';
$string['case:section:delete:confirm'] = 'Czy na pewno chcesz usunąć tę sekcję?';

// Resources
$string['resources:title']       = $string['concept:resources'];
$string['resources:header']      = $string['concept:resources'];
$string['resources:description'] = '<p>Odkryj szeroką gamę <span class="digitalta-highlighted">zasobów</span> udostępnionych przez nauczycieli z całego świata. Możesz znaleźć książki, filmy, strony internetowe i inne materiały dydaktyczne, które pomogą Ci ulepszyć praktykę nauczania, zaangażować uczniów i zainspirować lekcje. Możesz także udostępniać własne zasoby, aby przyczynić się do rozwoju społeczności.</p>';

// Resources - Management
$string['resources:manage:add']                     = 'Dodaj zasób';
$string['resources:manage:add:description']         = 'Możesz dodać nowy zasób do repozytorium, wypełniając wymagane pola poniżej.';
$string['resources:manage:name']                    = 'Nazwa';
$string['resources:manage:name:placeholder']        = 'Wprowadź nazwę zasobu...';
$string['resources:manage:path']                    = 'Link';
$string['resources:manage:path:placeholder']        = 'Wprowadź łącze do zasobu...';
$string['resources:manage:description']             = 'Opis';
$string['resources:manage:description:placeholder'] = 'Wprowadź krótki opis zasobu...';
$string['resources:manage:themes']                  = $string['concept:themes'];
$string['resources:manage:tags']                    = $string['concept:tags'];
$string['resources:manage:type']                    = 'Typ';
$string['resources:manage:language']                = $string['concept:language'];

// Resource - Actions
$string['resource:delete']         = 'Usuń zasób';
$string['resource:delete:confirm'] = 'Czy na pewno chcesz usunąć ten zasób?';
$string['resource:delete:success'] = 'Zasób został pomyślnie usunięty';

// Tutors
$string['tutors:title']       = $string['concept:tutorsmentors'];
$string['tutors:header']      = $string['concept:tutorsmentors'];
$string['tutors:description'] = '<p>Połącz się z doświadczonymi <span class="digitalta-highlighted">nauczycielami</span> i <span class="digitalta-highlighted">mentorami</span>, którzy mogą pomóc ci zastanowić się nad twoją praktyką nauczania, przekazać informacje zwrotne i zaoferować cenne spostrzeżenia. Możesz poprosić o sesje korepetycji, zadawać pytania i uzyskać spersonalizowane wsparcie, aby poprawić swoje umiejętności nauczania i wzmocnić pozycję swoich uczniów.';

// Profile
$string['profile:title']  = 'Profil';
$string['profile:header'] = 'Profil';

// Elements - Components
$string['component:experience'] = $string['concept:experience'];
$string['component:case']       = $string['concept:case'];
$string['component:resource']   = $string['concept:resource'];
$string['component:user']       = $string['concept:user'];

// Elements - Modifiers
$string['modifier:theme'] = $string['concept:theme'];
$string['modifier:tag']   = $string['concept:tag'];

// Elements - Themes
$string['theme:digital_technology']                         = 'Technologia cyfrowa';
$string['theme:classroom_management']                       = 'Zarządzanie klasą';
$string['theme:communication_and_relationship_building']    = 'Komunikacja i budowanie relacji';
$string['theme:diversity_and_inclusion']                    = 'Różnorodność i integracja';
$string['theme:professional_collaboration_and_development'] = 'Profesjonalna współpraca i rozwój';
$string['theme:school_culture']                             = 'Kultura szkoły';
$string['theme:curriculum_planning_and_development']        = 'Planowanie i rozwój programu nauczania';
$string['theme:others']                                     = 'Inne';

// Elements - Resource types
$string['resource_type:other']       = 'Inne';
$string['resource_type:book']        = 'Książka';
$string['resource_type:chart']       = 'Wykres';
$string['resource_type:comic']       = 'Komiks';
$string['resource_type:diary']       = 'Pamiętnik';
$string['resource_type:field_notes'] = 'Uwagi terenowe';
$string['resource_type:image']       = 'Obraz';
$string['resource_type:interview']   = 'Wywiad';
$string['resource_type:journal']     = 'Dziennik';
$string['resource_type:magazine']    = 'Magazyn';
$string['resource_type:map']         = 'Mapa';
$string['resource_type:music']       = 'Muzyka';
$string['resource_type:newspaper']   = 'Gazeta';
$string['resource_type:photograph']  = 'Zdjęcie';
$string['resource_type:podcast']     = 'Podcast';
$string['resource_type:report']      = 'Raport';
$string['resource_type:study_case']  = 'Studium przypadku';
$string['resource_type:video']       = 'Wideo';
$string['resource_type:website']     = 'Strona internetowa';

// Elements - Resource formats
$string['resource_format:none']     = 'Brak';
$string['resource_format:link']     = 'Link';
$string['resource_format:image']    = 'Obraz';
$string['resource_format:video']    = 'Wideo';
$string['resource_format:document'] = 'Dokument';

// Elements - Section groups
$string['section_group:general']  = 'Ogólne';
$string['section_group:what']     = 'Co?';
$string['section_group:so_what']  = 'I co z tego?';
$string['section_group:now_what'] = 'Co teraz?';

// Elements - Section types
$string['section_type:text'] = 'Tekst';














// Tutor Repository - MyTutoring
$string['tutor_searchbar_placeholder'] = 'Wyszukaj korepetytora...';

// Filters
$string['filter_themes_label'] = 'Tematy';
$string['filter_themes_placeholder'] = 'Wybierz motyw...';
$string['filter_tags_label'] = 'Tagi';
$string['filter_tags_placeholder'] = 'Wybierz tag...';
$string['filter_language_label'] = 'Język';
$string['filter_language_placeholder'] = 'Wybierz język...';

// Tutoring
$string['tutoring:request'] = 'Wniosek o korepetycje';
$string['tutoring:title'] = 'MOJE KOREPETYCJE';
$string['tutoring:back_to_chat'] = 'Powrót do czatu';
$string['tutoring:tutor_comments'] = 'Komentarz prowadzącego';
$string['tutoring:open_chats'] = 'Otwarte czaty';
$string['tutoring:view_tooltip'] = 'Wyświetl etykietę narzędzia';
$string['tutoring:videocallbutton'] = 'Rozpocznij połączenie Google Meet';
$string['tutoring:joinvideocall'] = 'Dołącz do rozmowy Google Meet';
$string['tutoring:closevideocall'] = 'Niewiele brakowało';
$string['tutoring:at_university'] = 'Nauczyciel w';
