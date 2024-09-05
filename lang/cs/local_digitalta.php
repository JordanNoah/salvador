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
$string['config:issuerid'] = 'Služba OAuth pro integraci služby Google Meet';

// General
$string['general:platform_name']       = 'Učitelská akademie';
$string['general:required']            = '<span style="color: red;">*</span> Prvky označené červenou hvězdičkou jsou povinné.';
$string['general:no_elements']         = 'Žádné prvky k zobrazení';
$string['general:see_more']            = 'Viz více';
$string['general:learn_more']          = 'Zjistěte více';
$string['general:video_not_supported'] = 'Váš prohlížeč nepodporuje značku videa.';
$string['general:date_timeago']        = '{$a} před';
$string['general:date_justnow']        = 'Právě teď';
$string['general:avatar_alt']          = 'Avatar uživatele';
$string['general:lang_pluri']          = 'Vícejazyčné';

// Concepts / terms
$string['concept:experience']    = 'Zkušenosti';
$string['concept:experiences']   = 'Zkušenosti';
$string['concept:case']          = 'Případ';
$string['concept:cases']         = 'Případy';
$string['concept:resource']      = 'Zdroje';
$string['concept:resources']     = 'Zdroje';
$string['concept:user']          = 'Uživatel';
$string['concept:users']         = 'Uživatelé';
$string['concept:theme']         = 'Téma';
$string['concept:themes']        = 'Témata';
$string['concept:tag']           = 'Štítek';
$string['concept:tags']          = 'Štítky';
$string['concept:themestags']    = 'Témata a značky';
$string['concept:language']      = 'Jazyk';
$string['concept:reflection']    = 'Reflexe';
$string['concept:tutor']         = 'Školitel';
$string['concept:tutors']        = 'Doučovatelé';
$string['concept:mentor']        = 'Mentor';
$string['concept:mentors']       = 'Mentoři';
$string['concept:tutorsmentors'] = 'Lektoři a mentoři';
$string['concept:introduction']  = 'Úvod';


// Concepts / terms - Definitions
$string['concept:experience:definition'] = 'Zážitek je reálná výuková praxe, kterou učitel sdílí. Může se jednat o plán hodiny, aktivitu ve třídě, reflexi nebo jakýkoli jiný obsah související s výukou.';
$string['concept:case:definition']       = 'Případ je podrobný popis reálné výukové zkušenosti. Zahrnuje kontext, problém, přijatá opatření, výsledky a úvahy učitele.';
$string['concept:resource:definition']   = 'Zdrojem je materiál související s výukou, který lze použít k podpoře výuky, činnosti nebo reflexe. Může to být kniha, video, webová stránka nebo jakýkoli jiný typ obsahu.';
$string['concept:theme:definition']      = 'Téma je široké téma nebo předmět, který je relevantní pro výuku a vzdělávání. Lze ji použít ke kategorizaci zkušeností, případů a zdrojů.';
$string['concept:tag:definition']        = 'Značka je klíčové slovo nebo štítek, který se používá k popisu obsahu zkušenosti, případu nebo zdroje. Lze jej použít k usnadnění vyhledávání a zjišťování.';

// Concepts / terms - Tutorials
$string['concept:experience:tutorial_intro'] = 'Základem Učitelské akademie jsou zážitky. Jedná se o reálné postupy výuky, které sdílejí učitelé, jako jste vy. Můžete prozkoumat své zkušenosti, přemýšlet o nich a učit se z postřehů a zkušeností svých kolegů.';
$string['concept:experience:tutorial_steps'] = '<ol>
    <li>Přidejte název svého zážitku.</li>
    <li>Vyplňte povinná pole (jazyk, obrázek, viditelnost, témata).</li>
    <li>Vložte stručný popis svého zážitku.</li>
    <li>Kliknutím na tlačítko "Post" svůj zážitek zveřejníte.</li>
</ol>';

// Visibility
$string['visibility:public']  = 'Veřejnost';
$string['visibility:private'] = 'Soukromé';

// Actions
$string['actions:edit']   = 'Upravit';
$string['actions:lock']   = 'Zámek';
$string['actions:unlock'] = 'Odemknutí stránky';
$string['actions:delete'] = 'Odstranit';
$string['actions:import'] = 'Import';
$string['actions:export'] = 'Export';

// Reactions
$string['reactions:like']            = 'Stejně jako';
$string['reactions:dislike']         = 'Nemít rád';
$string['reactions:comments']        = 'Komentáře';
$string['reactions:add_new_comment'] = 'Přidat nový komentář';
$string['reactions:report']          = 'Nahlásit';

// Teacher Academy
$string['teacheracademy:header']      = $string['general:platform_name'];
$string['teacheracademy:title']       = $string['general:platform_name'];
$string['teacheracademy:description'] = '<p>Vítejte v <span class="digitalta-highlighted-upper">Akademii pro učitele</span>, vašem společném prostoru pro profesní růst! Zde můžete prozkoumat <span class="digitalta-highlighted">reálné zkušenosti z výuky</span>, spojit se s <span class="digitalta-highlighted">učiteli</span>, získat přístup k bohatým <span class="digitalta-highlighted">zdroje pro výuku</span>, pokládat <span class="digitalta-highlighted">otázky</span> a čerpat inspiraci z různých <span class="digitalta-highlighted">praktik výuky</span>. Vydejte se na cestu a zapojte se do naší živé komunity a podpořte další generaci studentů. Pojďme společně změnit vzdělávání!</p>';

// Teacher Academy - Actions
$string['teacheracademy:actions:question']    = '{$a}, co chceš dnes dělat?';
$string['teacheracademy:actions:explore']     = 'Prozkoumejte zážitky';
$string['teacheracademy:actions:ask']         = 'Položit otázku';
$string['teacheracademy:actions:share']       = 'Podělte se o své zkušenosti';
$string['teacheracademy:actions:connect']     = 'Spojte se s odborníky';
$string['teacheracademy:actions:discover']    = 'Objevte zdroje';
$string['teacheracademy:actions:getinspired'] = 'Inspirujte se skutečnými případy';
$string['teacheracademy:actions:create']      = 'Vytvoření nového případu';

// Teacher Academy - Actions - Add modal
$string['teacheracademy:actions:ask:description']       = 'Položení otázky týkající se konkrétní zkušenosti s výukou je skvělým způsobem, jak zahájit proces reflexe. Získáte tak zpětnou vazbu od ostatních učitelů a odborníků a budete se moci poučit z jejich zkušeností.';
$string['teacheracademy:actions:ask:title']             = 'Začněte zadáním <span class="digitalta-highlighted">otázky</span> níže:';
$string['teacheracademy:actions:ask:title:placeholder'] = 'Zadejte svůj dotaz...';
$string['teacheracademy:actions:ask:picture']           = 'Nahrajte obrázek, který odráží vaši otázku. Tento obrázek je nepovinný a slouží pouze jako dekorace. Do popisu otázky lze přidat další obrázky.';
$string['teacheracademy:actions:ask:visibility']        = 'Chcete, aby vaše otázka byla <span class="digitalta-highlighted">veřejná</span> nebo <span class="digitalta-highlighted">soukromá</span>?';
$string['teacheracademy:actions:ask:language']          = 'Vyberte <span class="digitalta-highlighted">jazyk</span> své otázky:';
$string['teacheracademy:actions:ask:themes']            = 'Vyberte <span class="digitalta-highlighted">témata</span>, která nejlépe vystihují vaši otázku:';
$string['teacheracademy:actions:ask:tags']              = 'Přidejte <span class="digitalta-highlighted">značky</span> ke své otázce:';

$string['teacheracademy:actions:share:description']       = 'Sdílení zkušeností je účinný způsob, jak se zamyslet nad svou pedagogickou praxí, učit se od ostatních a inspirovat ostatní pedagogy.';
$string['teacheracademy:actions:share:title']             = 'Začněte tím, že zadáte výstižný <span class="digitalta-highlighted">název</span> své zkušenosti:';
$string['teacheracademy:actions:share:title:placeholder'] = 'Zadejte název...';
$string['teacheracademy:actions:share:picture']           = 'Nahrajte obrázek, který odráží vaše zkušenosti. Tento obrázek je nepovinný a slouží pouze jako dekorace. Do popisu zážitku lze přidat další obrázky.';
$string['teacheracademy:actions:share:visibility']        = 'Chcete, aby vaše zkušenost byla <span class="digitalta-highlighted">veřejná</span> nebo <span class="digitalta-highlighted">soukromá</span>?';
$string['teacheracademy:actions:share:language']          = 'Vyberte <span class="digitalta-highlighted">jazyk</span> své zkušenosti:';
$string['teacheracademy:actions:share:themes']            = 'Vyberte <span class="digitalta-highlighted">témata</span>, která nejlépe vystihují vaše zkušenosti:';
$string['teacheracademy:actions:share:tags']              = 'Přidejte <span class="digitalta-highlighted">značky</span> ke svým zkušenostem:';

// Themes & Tags
$string['themestags:title']            = $string['concept:themestags'];
$string['themestags:header']           = $string['concept:themestags'];
$string['themestags:description']      = '<p>Prozkoumejte naše <span class="digitalta-highlighted">témata</span> a <span class="digitalta-highlighted">značky</span> a najděte nejvhodnější <span class="digitalta-highlighted">zkušenosti</span>, <span class="digitalta-highlighted">případy</span> a <span class="digitalta-highlighted">zdroje</span> sdílené naší komunitou.</p>';
$string['themestags:view:description'] = '<p>Objevte nejdůležitější <span class="digitalta-highlighted">zkušenosti</span>, <span class="digitalta-highlighted">případy</span>.a <span class="digitalta-highlighted">zdroje</span> sdílené naší komunitou o <span class="digitalta-highlighted-upper">{$a}</span>.</p>';
$string['themestags:invalidthemetag']  = 'Neplatná značka nebo téma';

// Experiences
$string['experiences:title']       = $string['concept:experiences'];
$string['experiences:header']      = $string['concept:experiences'];
$string['experiences:description'] = '<p>Prozkoumejte širokou škálu <span class="digitalta-highlighted">zkušeností</span>, o které se podělili učitelé z celého světa. Můžete se poučit z jejich postřehů, zamyslet se nad jejich postupy a inspirovat se jejich příběhy. Můžete se s nimi také spojit, klást otázky a sdílet své vlastní zkušenosti a přispět tak ke komunitě.</p>';

// Experience - Actions
$string['experience:featured']       = 'Doporučené stránky';
$string['experience:lock']           = 'Zkušenosti se zámky';
$string['experience:lock:confirm']   = 'Jste si jisti, že chcete tuto zkušenost uzamknout?';
$string['experience:unlock']         = 'Odemknout zkušenosti';
$string['experience:unlock:confirm'] = 'Jste si jisti, že chcete tuto zkušenost odemknout?';
$string['experience:delete']         = 'Smazat zkušenost';
$string['experience:delete:confirm'] = 'Jste si jisti, že chcete tuto zkušenost smazat?';
$string['experience:delete:success'] = 'Zkušenosti úspěšně odstraněny';
$string['experience:export']         = 'Zkušenosti s vývozem do případu';

// Experience - Tutoring
$string['experience:tutoring:title']       = 'Doučovatelé';
$string['experience:tutoring:description'] = 'Lektoři jsou skvělým způsobem, jak získat individuální podporu a poradenství v oblasti výuky. Můžete si vyžádat doučování se zkušenými pedagogy, kteří vám pomohou reflektovat vaše zkušenosti, poskytnou vám zpětnou vazbu a nabídnou cenné postřehy.';
$string['experience:tutoring:see_all']     = 'Zobrazit všechny lektory';
$string['experience:tutoring:placeholder'] = 'Vyhledávání lektorů nebo mentorů...';
$string['experience:tutoring:notutors']    = 'K této zkušenosti nejsou přiřazeni žádní lektoři ani mentoři.';

// Experience - Reflection
$string['experience:reflection:title']                = 'Reflexe vašich zkušeností';
$string['experience:reflection:description']          = 'Proces sebereflexe jste zahájili popisem kontextu své zkušenosti. Nyní můžete pokračovat popisem toho, co jste udělali, proč jste to udělali a co se stalo, když jste to vyzkoušeli. Můžete se také zamyslet nad tím, co jste se naučili, jaký to mělo dopad a co byste měli dělat dál. Můžete také propojit všechny zdroje, které jste během tohoto procesu použili.';
$string['experience:reflection:edit']                 = 'Odrazit';
$string['experience:reflection:what']                 = 'Cože?';
$string['experience:reflection:what:description']     = 'Stručně popište <span class="digitalta-highlighted">kontext</span> své zkušenosti. Popište, co se děje ve vaší třídě? O co jde? Na co jste mysleli/co jste cítili?';
$string['experience:reflection:so_what']              = 'No a co?';
$string['experience:reflection:so_what:description']  = 'Jak jste se o tom <span class="digitalta-highlighted">dozvěděli více</span>? Kolegové, literatura, učitelé... Koho jste se ptali? Co jste četli?';
$string['experience:reflection:now_what']             = 'Co teď?';
$string['experience:reflection:now_what:description'] = 'Co jste udělali, proč jste to udělali a co se stalo, když jste to vyzkoušeli? Co jste se <span class="digitalta-highlighted">naučili</span>, jaký to mělo dopad a co byste měli dělat dál?';
$string['experience:reflection:empty']                = 'Tato část procesu reflexe zatím nebyla provedena.';

// Experience - Resources
$string['experience:resources:link']             = 'Zdroje odkazů';
$string['experience:resources:link:description'] = 'Zdroje z úložiště můžete propojit se svými zkušenostmi.';
$string['experience:resources:unlink']           = 'Odpojení zdroje';
$string['experience:resources:unlink:confirm']   = 'Jste si jisti, že chcete tento zdroj odpojit od zkušeností?';
$string['experience:resources:add_new']          = 'Přidání nového prostředku';
$string['experience:resources:description']      = 'Proč jste si vybrali tento zdroj? Jak jste ho používali? Co jste se z ní naučili?';
$string['experience:resources:empty']            = 'S touto zkušeností zatím nejsou spojeny žádné zdroje.';
$string['experience:resources:visit']            = 'Navštivte zdroj';

// Cases
$string['cases:title']       = $string['concept:cases'];
$string['cases:header']      = $string['concept:cases'];
$string['cases:description'] = '<p>Prozkoumejte sbírku <span class="digitalta-highlighted">případů</span>, o které se podělili učitelé z celého světa. Každý případ je podrobným popisem reálné zkušenosti s výukou, včetně kontextu, problému, přijatých opatření, výsledků a úvah učitele.</p>';

// Cases - Management
$string['cases:manage']                 = 'Správa případů';
$string['cases:manage:add']             = 'Přidání nového případu';
$string['cases:manage:add:button']      = 'Přidat';
$string['cases:manage:add:placeholder'] = 'Zadejte název případu...';
$string['cases:manage:title']           = 'Název';
$string['cases:manage:description']     = 'Popis';
$string['cases:manage:themes']          = $string['concept:themes'];
$string['cases:manage:tags']            = $string['concept:tags'];
$string['cases:manage:language']        = $string['concept:language'];

// Case - Actions
$string['case:delete']         = 'Odstranit případ';
$string['case:delete:confirm'] = 'Opravdu chcete tento případ odstranit?';
$string['case:delete:success'] = 'Případ úspěšně odstraněn';
$string['case:save']           = 'Uložit případ';
$string['case:save:confirm']   = 'Jste si jistý, že chcete tento případ zachránit?';

// Case - Sections
$string['case:section:add']            = 'Přidat oddíl';
$string['case:section:delete']         = 'Vymazat oddíl';
$string['case:section:delete:confirm'] = 'Opravdu chcete tuto část odstranit?';

// Resources
$string['resources:title']       = $string['concept:resources'];
$string['resources:header']      = $string['concept:resources'];
$string['resources:description'] = '<p>Objevte širokou škálu <span class="digitalta-highlighted">zdrojů</span>, které sdílejí učitelé z celého světa. Najdete zde knihy, videa, webové stránky a další výukové materiály, které vám pomohou zlepšit vaši pedagogickou praxi, zaujmout studenty a inspirovat vaše hodiny. Můžete také sdílet své vlastní zdroje a přispět tak ke komunitě.</p>';

// Resources - Management
$string['resources:manage:add']                     = 'Přidat zdroj';
$string['resources:manage:add:description']         = 'Nový prostředek můžete do úložiště přidat vyplněním níže uvedených povinných polí.';
$string['resources:manage:name']                    = 'Název';
$string['resources:manage:name:placeholder']        = 'Zadejte název prostředku...';
$string['resources:manage:path']                    = 'Odkaz';
$string['resources:manage:path:placeholder']        = 'Zadejte odkaz na zdroj...';
$string['resources:manage:description']             = 'Popis';
$string['resources:manage:description:placeholder'] = 'Zadejte stručný popis zdroje...';
$string['resources:manage:themes']                  = $string['concept:themes'];
$string['resources:manage:tags']                    = $string['concept:tags'];
$string['resources:manage:type']                    = 'Typ';
$string['resources:manage:language']                = $string['concept:language'];

// Resource - Actions
$string['resource:delete']         = 'Odstranit zdroj';
$string['resource:delete:confirm'] = 'Opravdu chcete tento zdroj odstranit?';
$string['resource:delete:success'] = 'Prostředek úspěšně odstraněn';

// Tutors
$string['tutors:title']       = $string['concept:tutorsmentors'];
$string['tutors:header']      = $string['concept:tutorsmentors'];
$string['tutors:description'] = '<p>Spojte se se zkušenými <span class="digitalta-highlighted">učiteli</span> a <span class="digitalta-highlighted">mentory</span>, kteří vám pomohou zamyslet se nad vaší výukovou praxí, poskytnou zpětnou vazbu a nabídnou cenné postřehy. Můžete si vyžádat doučování, klást otázky a získat individuální podporu, abyste zlepšili své učitelské dovednosti a posílili své studenty.</p>';

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
$string['theme:digital_technology']                         = 'Digitální technologie';
$string['theme:classroom_management']                       = 'Řízení třídy';
$string['theme:communication_and_relationship_building']    = 'Komunikace a budování vztahů';
$string['theme:diversity_and_inclusion']                    = 'Diverzita a inkluze';
$string['theme:professional_collaboration_and_development'] = 'Odborná spolupráce a rozvoj';
$string['theme:school_culture']                             = 'Kultura školy';
$string['theme:curriculum_planning_and_development']        = 'Plánování a vývoj učebních osnov';
$string['theme:others']                                     = 'Ostatní';

// Elements - Resource types
$string['resource_type:other']       = 'Další';
$string['resource_type:book']        = 'Kniha';
$string['resource_type:chart']       = 'Graf';
$string['resource_type:comic']       = 'Komiks';
$string['resource_type:diary']       = 'Deník';
$string['resource_type:field_notes'] = 'Poznámky z terénu';
$string['resource_type:image']       = 'Obrázek';
$string['resource_type:interview']   = 'Rozhovor';
$string['resource_type:journal']     = 'Deník';
$string['resource_type:magazine']    = 'Časopis';
$string['resource_type:map']         = 'Mapa';
$string['resource_type:music']       = 'Hudba';
$string['resource_type:newspaper']   = 'Noviny';
$string['resource_type:photograph']  = 'Fotografie';
$string['resource_type:podcast']     = 'Podcast';
$string['resource_type:report']      = 'Nahlásit';
$string['resource_type:study_case']  = 'Studijní případ';
$string['resource_type:video']       = 'Video';
$string['resource_type:website']     = 'Webové stránky';

// Elements - Resource formats
$string['resource_format:none']     = 'Žádné';
$string['resource_format:link']     = 'Odkaz';
$string['resource_format:image']    = 'Obrázek';
$string['resource_format:video']    = 'Video';
$string['resource_format:document'] = 'Dokument';

// Elements - Section groups
$string['section_group:general']  = 'Obecné';
$string['section_group:what']     = 'Cože?';
$string['section_group:so_what']  = 'No a co?';
$string['section_group:now_what'] = 'Co teď?';

// Elements - Section types
$string['section_type:text'] = 'Text';














// Tutor Repository - MyTutoring
$string['tutor_searchbar_placeholder'] = 'Vyhledejte učitele...';

// Filters
$string['filter_themes_label'] = 'Témata';
$string['filter_themes_placeholder'] = 'Vyberte si téma...';
$string['filter_tags_label'] = 'Štítky';
$string['filter_tags_placeholder'] = 'Vyberte značku...';
$string['filter_language_label'] = 'Jazyk';
$string['filter_language_placeholder'] = 'Vyberte jazyk...';

// Tutoring
$string['tutoring:request'] = 'Žádost o doučování';
$string['tutoring:title'] = 'MOJE UČITELSTVÍ';
$string['tutoring:back_to_chat'] = 'Zpět na chat';
$string['tutoring:tutor_comments'] = 'Komentáře školitele';
$string['tutoring:open_chats'] = 'Otevřené chaty';
$string['tutoring:view_tooltip'] = 'Zobrazit nápovědu k nástroji';
$string['tutoring:videocallbutton'] = 'Zahájení hovoru Google Meet';
$string['tutoring:joinvideocall'] = 'Připojte se k hovoru Google Meet';
$string['tutoring:closevideocall'] = 'Těsný souboj';
$string['tutoring:at_university'] = 'Učitel na';
