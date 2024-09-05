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
$string['config:issuerid'] = 'OAuth service for Google Meet integration';

// General
$string['general:platform_name']       = 'Teacher Academy';
$string['general:required']            = '<span style="color: red;">*</span> Elements marked with a red asterisk are required.';
$string['general:required:missing']    = 'Please fill in all required fields.';
$string['general:no_elements']         = 'No elements to show';
$string['general:see_more']            = 'See more';
$string['general:learn_more']          = 'Learn more';
$string['general:video_not_supported'] = 'Your browser does not support the video tag.';
$string['general:date_timeago']        = '{$a} ago';
$string['general:date_justnow']        = 'Just now';
$string['general:avatar_alt']          = 'User avatar';
$string['general:lang_pluri']          = 'Plurilingual';

// Concepts / terms
$string['concept:experience']    = 'Experience';
$string['concept:experiences']   = 'Experiences';
$string['concept:case']          = 'Case';
$string['concept:cases']         = 'Cases';
$string['concept:resource']      = 'Resource';
$string['concept:resources']     = 'Resources';
$string['concept:user']          = 'User';
$string['concept:users']         = 'Users';
$string['concept:theme']         = 'Theme';
$string['concept:themes']        = 'Themes';
$string['concept:tag']           = 'Tag';
$string['concept:tags']          = 'Tags';
$string['concept:themestags']    = 'Themes & Tags';
$string['concept:language']      = 'Language';
$string['concept:reflection']    = 'Reflection';
$string['concept:tutor']         = 'Tutor';
$string['concept:tutors']        = 'Tutors';
$string['concept:mentor']        = 'Mentor';
$string['concept:mentors']       = 'Mentors';
$string['concept:tutorsmentors'] = 'Tutors & Mentors';
$string['concept:introduction']  = 'Introduction';
$string['concept:conclusion']    = 'Conclusion';
$string['concept:summary']       = 'Summary';


// Concepts / terms - Definitions
$string['concept:experience:definition'] = 'An experience is a real-world teaching practice shared by a teacher. It can be a lesson plan, a classroom activity, a reflection, or any other teaching-related content.';
$string['concept:case:definition']       = 'A case is a detailed description of a real-world teaching experience. It includes the context, the problem, the actions taken, the results, and the reflections of the teacher.';
$string['concept:resource:definition']   = 'A resource is a teaching-related material that can be used to support a lesson, an activity, or a reflection. It can be a book, a video, a website, or any other type of content.';
$string['concept:theme:definition']      = 'A theme is a broad topic or subject that is relevant to teaching and education. It can be used to categorize experiences, cases, and resources.';
$string['concept:tag:definition']        = 'A tag is a keyword or label that is used to describe the content of an experience, a case, or a resource. It can be used to facilitate search and discovery.';

// Concepts / terms - Tutorials
$string['concept:experience:tutorial_intro'] = 'Experiences are the heart of the Teacher Academy. They are real-world teaching practices shared by teachers like you. You can explore experiences, reflect on them, and learn from the insights and experiences of your peers.';
$string['concept:experience:tutorial_steps'] = '<ol>
    <li>Add a title to your experience.</li>
    <li>Fill in the required fields (language, picture, visibility, themes).</li>
    <li>Enter a brief description of your experience.</li>
    <li>Click on the "Post" button to publish your experience.</li>
</ol>';

// Visibility
$string['visibility:public']  = 'Public';
$string['visibility:private'] = 'Private';

// Actions
$string['actions:edit']   = 'Edit';
$string['actions:lock']   = 'Lock';
$string['actions:unlock'] = 'Unlock';
$string['actions:delete'] = 'Delete';
$string['actions:import'] = 'Import';
$string['actions:export'] = 'Export';

// Reactions
$string['reactions:like']            = 'Like';
$string['reactions:dislike']         = 'Dislike';
$string['reactions:comments']        = 'Comments';
$string['reactions:add_new_comment'] = 'Add new comment';
$string['reactions:report']          = 'Report';

// Teacher Academy
$string['teacheracademy:header']      = $string['general:platform_name'];
$string['teacheracademy:title']       = $string['general:platform_name'];
$string['teacheracademy:description'] = '<p>Welcome to <span class="digitalta-highlighted-upper">Teacher Academy</span>, your collaborative space for professional growth! Here, you can explore <span class="digitalta-highlighted">real-world classroom experiences</span>, connect with <span class="digitalta-highlighted">tutors</span>, access a wealth of <span class="digitalta-highlighted">teaching resources</span>, ask <span class="digitalta-highlighted">questions</span>, and draw inspiration from diverse <span class="digitalta-highlighted">teaching practices</span>. Embark on your journey by engaging with our vibrant community and empowering the next generation of learners. Let\'s transform education together!</p>';

// Teacher Academy - Actions
$string['teacheracademy:actions:question']    = '{$a}, what do you want to do today?';
$string['teacheracademy:actions:explore']     = 'Explore Experiences';
$string['teacheracademy:actions:ask']         = 'Ask a Question';
$string['teacheracademy:actions:share']       = 'Share your Experience';
$string['teacheracademy:actions:connect']     = 'Connect with Experts';
$string['teacheracademy:actions:discover']    = 'Discover Resources';
$string['teacheracademy:actions:getinspired'] = 'Get Inspired by Real Cases';
$string['teacheracademy:actions:create']      = 'Create a New Case';

// Teacher Academy - Actions - Add modal
$string['teacheracademy:actions:ask:description']       = 'Asking a question about a particular teaching experience is a great way to initiate your reflection process. By doing so, you will be able to get feedback from other teachers and experts, and learn from their experiences.';
$string['teacheracademy:actions:ask:title']             = 'Start by entering your <span class="digitalta-highlighted">question</span> below:';
$string['teacheracademy:actions:ask:title:placeholder'] = 'Enter your question...';
$string['teacheracademy:actions:ask:picture']           = 'Upload a picture that reflects your question. This image is optional and will serve as decoration only. Additional images can be added to the question description.';
$string['teacheracademy:actions:ask:visibility']        = 'Do you want your question to be <span class="digitalta-highlighted">public</span> or <span class="digitalta-highlighted">private</span>?';
$string['teacheracademy:actions:ask:language']          = 'Select the <span class="digitalta-highlighted">language</span> of your question:';
$string['teacheracademy:actions:ask:themes']            = 'Select the <span class="digitalta-highlighted">themes</span> that best describe your question:';
$string['teacheracademy:actions:ask:tags']              = 'Add <span class="digitalta-highlighted">tags</span> to your question:';

$string['teacheracademy:actions:share:description']       = 'Sharing your experience is a powerful way to reflect on your teaching practice, learn from others, and inspire fellow educators.';
$string['teacheracademy:actions:share:title']             = 'Start by entering a meaningful <span class="digitalta-highlighted">title</span> for your experience:';
$string['teacheracademy:actions:share:title:placeholder'] = 'Enter a title...';
$string['teacheracademy:actions:share:picture']           = 'Upload a picture that reflects your experience. This image is optional and will serve as decoration only. Additional images can be added to the experience description.';
$string['teacheracademy:actions:share:visibility']        = 'Do you want your experience to be <span class="digitalta-highlighted">public</span> or <span class="digitalta-highlighted">private</span>?';
$string['teacheracademy:actions:share:language']          = 'Select the <span class="digitalta-highlighted">language</span> of your experience:';
$string['teacheracademy:actions:share:themes']            = 'Select the <span class="digitalta-highlighted">themes</span> that best describe your experience:';
$string['teacheracademy:actions:share:tags']              = 'Add <span class="digitalta-highlighted">tags</span> to your experience:';

// Themes & Tags
$string['themestags:title']            = $string['concept:themestags'];
$string['themestags:header']           = $string['concept:themestags'];
$string['themestags:description']      = '<p>Explore our <span class="digitalta-highlighted">themes</span> and <span class="digitalta-highlighted">tags</span> to find the most relevant <span class="digitalta-highlighted">experiences</span>, <span class="digitalta-highlighted">cases</span>, and <span class="digitalta-highlighted">resources</span> shared by our community.</p>';
$string['themestags:view:description'] = '<p>Discover the most relevant <span class="digitalta-highlighted">experiences</span>, <span class="digitalta-highlighted">cases</span>, and <span class="digitalta-highlighted">resources</span> shared by our community about <span class="digitalta-highlighted-upper">{$a}</span></p>';
$string['themestags:invalidthemetag']  = 'Invalid tag or theme';

// Experiences
$string['experiences:title']       = $string['concept:experiences'];
$string['experiences:header']      = $string['concept:experiences'];
$string['experiences:description'] = '<p>Explore a wide range of <span class="digitalta-highlighted">experiences</span> shared by teachers from around the world. You can learn from their insights, reflect on their practices, and get inspired by their stories. You can also connect with them, ask questions, and share your own experiences to contribute to the community.</p>';

// Experience - Actions
$string['experience:featured']       = 'Featured';
$string['experience:lock']           = 'Lock experience';
$string['experience:lock:confirm']   = 'Are you sure you want to lock this experience?';
$string['experience:unlock']         = 'Unlock experience';
$string['experience:unlock:confirm'] = 'Are you sure you want to unlock this experience?';
$string['experience:delete']         = 'Delete experience';
$string['experience:delete:confirm'] = 'Are you sure you want to delete this experience?';
$string['experience:delete:success'] = 'Experience deleted successfully';
$string['experience:export']         = 'Export experience to case';

// Experience - Tutoring
$string['experience:tutoring:title']       = 'Tutors';
$string['experience:tutoring:description'] = 'Tutors are a great way to get personalized support and guidance on your teaching practice. You can request tutoring sessions with experienced educators who can help you reflect on your experiences, provide feedback, and offer valuable insights.';
$string['experience:tutoring:see_all']     = 'See all tutors';
$string['experience:tutoring:placeholder'] = 'Search for tutors or mentors...';
$string['experience:tutoring:notutors']    = 'No tutors or mentors assigned to this experience.';

// Experience - Reflection
$string['experience:reflection:title']                = 'Reflecting on your experience';
$string['experience:reflection:description']          = 'You started your self-reflection process when describing the context of your experience. Now, you can continue by describing what you did, why you did it, and what happened when you tried it out. You can also reflect on what you learned, what impact it had, and what you should do next. You can also link any resources that you used during this process.';
$string['experience:reflection:edit']                 = 'Reflect';
$string['experience:reflection:what']                 = 'What?';
$string['experience:reflection:what:description']     = 'Briefly describe the <span class="digitalta-highlighted">context</span> of your experience. Describe what is happening in your class? What is the issue? What were you thinking/feeling?';
$string['experience:reflection:so_what']              = 'So What?';
$string['experience:reflection:so_what:description']  = 'How did you <span class="digitalta-highlighted">find out more</span> about this? Colleagues, literature, tutor... Who did you ask? What did you read?';
$string['experience:reflection:now_what']             = 'Now What?';
$string['experience:reflection:now_what:description'] = 'What did you do, why did you do it, and what happened when you tried it out? What did you <span class="digitalta-highlighted">learn</span>, what impact did it have, and what should you do next?';
$string['experience:reflection:empty']                = 'This part of the reflection process has not been taken yet.';

// Experience - Resources
$string['experience:resources:link']             = 'Link resources';
$string['experience:resources:link:description'] = 'You can link resources from the repository to your experience.';
$string['experience:resources:unlink']           = 'Unlink resource';
$string['experience:resources:unlink:confirm']   = 'Are you sure you want to unlink this resource from the experience?';
$string['experience:resources:add_new']          = 'Add a new resource';
$string['experience:resources:description']      = 'Why did you choose this resource? How did you use it? What did you learn from it?';
$string['experience:resources:empty']            = 'No resources linked to this experience yet.';
$string['experience:resources:visit']            = 'Visit resource';

// Cases
$string['cases:title']       = $string['concept:cases'];
$string['cases:header']      = $string['concept:cases'];
$string['cases:description'] = '<p>Explore a collection of <span class="digitalta-highlighted">cases</span> shared by teachers from around the world. Each case is a detailed description of a real-world teaching experience, including the context, the problem, the actions taken, the results, and the reflections of the teacher.</p>';

// Cases - Management
$string['cases:manage']                 = 'Manage cases';
$string['cases:manage:add']             = 'Add a new case';
$string['cases:manage:add:button']      = 'Add';
$string['cases:manage:add:placeholder'] = 'Enter the title of the case...';
$string['cases:manage:title']           = 'Title';
$string['cases:manage:description']     = 'Description';
$string['cases:manage:themes']          = $string['concept:themes'];
$string['cases:manage:tags']            = $string['concept:tags'];
$string['cases:manage:language']        = $string['concept:language'];
$string['cases:manage:new']             = 'New case';

// Case - Actions
$string['case:delete']                     = 'Delete case';
$string['case:delete:confirm']             = 'Are you sure you want to delete this case?';
$string['case:delete:success']             = 'Case deleted successfully';
$string['case:save']                       = 'Save case';
$string['case:save:confirm']               = 'Are you sure you want to save this case?';
$string['case:save:error:editingsections'] = 'Please finish editing the sections before saving the case.';

// Case - Sections
$string['case:section:add']            = 'Add section';
$string['case:section:delete']         = 'Delete section';
$string['case:section:delete:confirm'] = 'Are you sure you want to delete this section?';
$string['case:section:title']          = 'Title';
$string['case:section:content']        = 'Content';

// Resources
$string['resources:title']       = $string['concept:resources'];
$string['resources:header']      = $string['concept:resources'];
$string['resources:description'] = '<p>Discover a wide range of <span class="digitalta-highlighted">resources</span> shared by teachers from around the world. You can find books, videos, websites, and other teaching materials that can help you enhance your teaching practice, engage your students, and inspire your lessons. You can also share your own resources to contribute to the community.</p>';

// Resources - Management
$string['resources:manage:add']                     = 'Add resource';
$string['resources:manage:add:description']         = 'You can add a new resource to the repository by filling in the required fields below.';
$string['resources:manage:name']                    = 'Name';
$string['resources:manage:name:placeholder']        = 'Enter the name of the resource...';
$string['resources:manage:path']                    = 'Link';
$string['resources:manage:path:placeholder']        = 'Enter the link to the resource...';
$string['resources:manage:description']             = 'Description';
$string['resources:manage:description:placeholder'] = 'Enter a brief description of the resource...';
$string['resources:manage:themes']                  = $string['concept:themes'];
$string['resources:manage:tags']                    = $string['concept:tags'];
$string['resources:manage:type']                    = 'Type';
$string['resources:manage:language']                = $string['concept:language'];

// Resource - Actions
$string['resource:delete']         = 'Delete resource';
$string['resource:delete:confirm'] = 'Are you sure you want to delete this resource?';
$string['resource:delete:success'] = 'Resource deleted successfully';

// Tutors
$string['tutors:title']       = $string['concept:tutorsmentors'];
$string['tutors:header']      = $string['concept:tutorsmentors'];
$string['tutors:description'] = '<p>Connect with experienced <span class="digitalta-highlighted">tutors</span> and <span class="digitalta-highlighted">mentors</span> who can help you reflect on your teaching practice, provide feedback, and offer valuable insights. You can request tutoring sessions, ask questions, and get personalized support to enhance your teaching skills and empower your students.</p>';

// Profile
$string['profile:title']  = 'Profile';
$string['profile:header'] = 'Profile';

// Elements - Components
$string['component:experience'] = $string['concept:experience'];
$string['component:case']       = $string['concept:case'];
$string['component:resource']   = $string['concept:resource'];
$string['component:user']       = $string['concept:user'];

// Elements - Modifiers
$string['modifier:theme'] = $string['concept:theme'];
$string['modifier:tag']   = $string['concept:tag'];

// Elements - Themes
$string['theme:digital_technology']                         = 'Digital Technology';
$string['theme:classroom_management']                       = 'Classroom Management';
$string['theme:communication_and_relationship_building']    = 'Communication and Relationship Building';
$string['theme:diversity_and_inclusion']                    = 'Diversity and Inclusion';
$string['theme:professional_collaboration_and_development'] = 'Professional Collaboration and Development';
$string['theme:school_culture']                             = 'School Culture';
$string['theme:curriculum_planning_and_development']        = 'Curriculum Planning and Development';
$string['theme:others']                                     = 'Others';

// Elements - Resource types
$string['resource_type:other']       = 'Other';
$string['resource_type:book']        = 'Book';
$string['resource_type:chart']       = 'Chart';
$string['resource_type:comic']       = 'Comic';
$string['resource_type:diary']       = 'Diary';
$string['resource_type:field_notes'] = 'Field Notes';
$string['resource_type:image']       = 'Image';
$string['resource_type:interview']   = 'Interview';
$string['resource_type:journal']     = 'Journal';
$string['resource_type:magazine']    = 'Magazine';
$string['resource_type:map']         = 'Map';
$string['resource_type:music']       = 'Music';
$string['resource_type:newspaper']   = 'Newspaper';
$string['resource_type:photograph']  = 'Photograph';
$string['resource_type:podcast']     = 'Podcast';
$string['resource_type:report']      = 'Report';
$string['resource_type:study_case']  = 'Study Case';
$string['resource_type:video']       = 'Video';
$string['resource_type:website']     = 'Website';

// Elements - Resource formats
$string['resource_format:none']     = 'None';
$string['resource_format:link']     = 'Link';
$string['resource_format:image']    = 'Image';
$string['resource_format:video']    = 'Video';
$string['resource_format:document'] = 'Document';

// Elements - Section groups
$string['section_group:general']  = 'General';
$string['section_group:what']     = 'What?';
$string['section_group:so_what']  = 'So What?';
$string['section_group:now_what'] = 'Now What?';

// Elements - Section types
$string['section_type:text'] = 'Text';














// Tutor Repository - MyTutoring
$string['tutor_searchbar_placeholder'] = 'Search a tutor...';

// Filters
$string['filter_themes_label'] = 'Themes';
$string['filter_themes_placeholder'] = 'Select a theme...';
$string['filter_tags_label'] = 'Tags';
$string['filter_tags_placeholder'] = 'Select a tag...';
$string['filter_language_label'] = 'Language';
$string['filter_language_placeholder'] = 'Select a language...';

// Tutoring
$string['tutoring:request'] = 'Tutoring Request';
$string['tutoring:title'] = 'MY TUTORING';
$string['tutoring:back_to_chat'] = 'Back to chat';
$string['tutoring:tutor_comments'] = 'Tutor comments';
$string['tutoring:open_chats'] = 'Open chats';
$string['tutoring:view_tooltip'] = 'View tooltip';
$string['tutoring:videocallbutton'] = 'Start Google Meet call';
$string['tutoring:joinvideocall'] = 'Join Google Meet call';
$string['tutoring:closevideocall'] = 'Close call';
$string['tutoring:at_university'] = 'Teacher at';
