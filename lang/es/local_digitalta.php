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
$string['config:issuerid'] = 'Servicio OAuth para la integración de Google Meet';

// General
$string['general:platform_name']       = 'Academia de Profesores';
$string['general:required']            = '<span style="color: rojo;">*</span> Los elementos marcados con un asterisco rojo son obligatorios.';
$string['general:required:missing']    = 'Por favor, rellene todos los campos obligatorios.';
$string['general:no_elements']         = 'No hay elementos que mostrar';
$string['general:see_more']            = 'Ver más';
$string['general:learn_more']          = 'Más información';
$string['general:video_not_supported'] = 'Su navegador no soporta la etiqueta de vídeo.';
$string['general:date_timeago']        = 'hace {$a}';
$string['general:date_justnow']        = 'Ahora mismo';
$string['general:avatar_alt']          = 'Avatar de usuario';
$string['general:lang_pluri']          = 'Plurilingüe';

// Concepts / terms
$string['concept:experience']    = 'Experiencia';
$string['concept:experiences']   = 'Experiencias';
$string['concept:case']          = 'Caso';
$string['concept:cases']         = 'Casos';
$string['concept:resource']      = 'Recurso';
$string['concept:resources']     = 'Recursos';
$string['concept:user']          = 'Usuario';
$string['concept:users']         = 'Usuarios';
$string['concept:theme']         = 'Tema';
$string['concept:themes']        = 'Temas';
$string['concept:tag']           = 'Etiqueta';
$string['concept:tags']          = 'Etiquetas';
$string['concept:themestags']    = 'Temas y etiquetas';
$string['concept:language']      = 'Idioma';
$string['concept:reflection']    = 'Reflexión';
$string['concept:tutor']         = 'Tutor';
$string['concept:tutors']        = 'Tutores';
$string['concept:mentor']        = 'Mentor';
$string['concept:mentors']       = 'Mentores';
$string['concept:tutorsmentors'] = 'Tutores y mentores';
$string['concept:introduction']  = 'Introducción';
$string['concept:conclusion']    = 'Conclusión';


// Concepts / terms - Definitions
$string['concept:experience:definition'] = 'Una experiencia es una práctica docente real compartida por un profesor. Puede ser la planificación de una clase, una actividad, una reflexión o cualquier otro contenido relacionado con la enseñanza.';
$string['concept:case:definition']       = 'Un caso es una descripción detallada de una experiencia docente real. Incluye el contexto, el problema, las acciones emprendidas, los resultados y las reflexiones del profesor.';
$string['concept:resource:definition']   = 'Un recurso es un material relacionado con la enseñanza que puede utilizarse como apoyo para una lección, una actividad o una reflexión. Puede ser un libro, un vídeo, un sitio web o cualquier otro tipo de contenido.';
$string['concept:theme:definition']      = 'Un tema es un asunto o tema amplio que es relevante para la enseñanza y la educación. Puede utilizarse para clasificar experiencias, casos y recursos.';
$string['concept:tag:definition']        = 'Una etiqueta es una palabra clave o una etiqueta que se utiliza para describir el contenido de una experiencia, un caso o un recurso. Puede utilizarse para facilitar la búsqueda y el descubrimiento.';

// Concepts / terms - Tutorials
$string['concept:experience:tutorial_intro'] = 'Las experiencias son el corazón de la Academia de Profesores. Son prácticas docentes reales compartidas por profesores como tú. Puedes explorar experiencias, reflexionar sobre ellas y aprender de las ideas y vivencias de tus compañeros.';
$string['concept:experience:tutorial_steps'] = '<ol>
    <li>Añade un título a tu experiencia.</li>
    <li>Rellena los campos obligatorios (idioma, imagen, visibilidad, temas).</li>
    <li>Introduce una breve descripción de tu experiencia.</li>
    <li>Haz clic en el botón "Publicar" para publicar tu experiencia.</li>
</ol>';

// Visibility
$string['visibility:public']  = 'Público';
$string['visibility:private'] = 'Privado';

// Actions
$string['actions:edit']   = 'Editar';
$string['actions:lock']   = 'Bloquear';
$string['actions:unlock'] = 'Desbloquear';
$string['actions:delete'] = 'Borrar';
$string['actions:import'] = 'Importar';
$string['actions:export'] = 'Exportar';

// Reactions
$string['reactions:like']            = 'Me gusta';
$string['reactions:dislike']         = 'No me gusta';
$string['reactions:comments']        = 'Comentarios';
$string['reactions:add_new_comment'] = 'Añadir un comentario';
$string['reactions:report']          = 'Informe';

// Teacher Academy
$string['teacheracademy:header']      = $string['general:platform_name'];
$string['teacheracademy:title']       = $string['general:platform_name'];
$string['teacheracademy:description'] = '<p>¡Bienvenidos a la <span class="digitalta-highlighted-upper">Academia de Profesores</span>, tu espacio colaborativo para el crecimiento profesional! Aquí puedes explorar <span class="digitalta-highlighted">experiencias reales en el aula</span>, conectar con <span class="digitalta-highlighted">tutores</span>, acceder a una gran cantidad de <span class="digitalta-highlighted">recursos</span> de apoyo a la enseñanza, formular <span class="digitalta-highlighted">preguntas</span> e inspirarte en diversas <span class="digitalta-highlighted">prácticas docentes</span>. Emprende junto a nuestra vibrante comunidad un viaje hacia el empoderamiento de la próxima generación de estudiantes. Transformemos juntos la educación.</p>';

// Teacher Academy - Actions
$string['teacheracademy:actions:question']    = '{$a}, ¿qué quieres hacer hoy?';
$string['teacheracademy:actions:explore']     = 'Explorar experiencias';
$string['teacheracademy:actions:ask']         = 'Formular una pregunta';
$string['teacheracademy:actions:share']       = 'Compartir una experiencia';
$string['teacheracademy:actions:connect']     = 'Conectar con expertos';
$string['teacheracademy:actions:discover']    = 'Descubrir recursos';
$string['teacheracademy:actions:getinspired'] = 'Inspirarme en casos reales';
$string['teacheracademy:actions:create']      = 'Crear un nuevo caso';

// Teacher Academy - Actions - Add modal
$string['teacheracademy:actions:ask:description']       = 'Formular una pregunta sobre una experiencia docente concreta es una buena manera de iniciar el proceso de reflexión. De este modo, puedes recibir comentarios de otros profesores y expertos y aprender de sus experiencias.';
$string['teacheracademy:actions:ask:title']             = 'Empieza por introducir tu <span class="digitalta-highlighted">pregunta</span> a continuación:';
$string['teacheracademy:actions:ask:title:placeholder'] = 'Introduce tu pregunta...';
$string['teacheracademy:actions:ask:picture']           = 'Sube una imagen que refleje tu pregunta. Esta imagen es opcional y sólo servirá como decoración. Se pueden añadir imágenes adicionales a la descripción de la pregunta.';
$string['teacheracademy:actions:ask:visibility']        = '¿Quieres que tu pregunta sea <span class="digitalta-highlighted">pública</span> o <span class="digitalta-highlighted">privada</span>?';
$string['teacheracademy:actions:ask:language']          = 'Selecciona el <span class="digitalta-highlighted">idioma</span> de tu pregunta:';
$string['teacheracademy:actions:ask:themes']            = 'Selecciona los <span class="digitalta-highlighted">temas</span> que mejor describan tu pregunta:';
$string['teacheracademy:actions:ask:tags']              = 'Añade <span class="digitalta-highlighted">etiquetas</span> a tu pregunta:';

$string['teacheracademy:actions:share:description']       = 'Compartir tu experiencia es una forma eficaz de reflexionar sobre tu práctica docente, aprender de los demás e inspirar a otros educadores.';
$string['teacheracademy:actions:share:title']             = 'Empieza por introducir un <span class="digitalta-highlighted">título</span> significativo para tu experiencia:';
$string['teacheracademy:actions:share:title:placeholder'] = 'Introduce un título...';
$string['teacheracademy:actions:share:picture']           = 'Sube una foto que refleje tu experiencia. Esta imagen es opcional y sólo servirá como decoración. Se pueden añadir imágenes adicionales a la descripción de la experiencia.';
$string['teacheracademy:actions:share:visibility']        = '¿Quieres que tu experiencia sea <span class="digitalta-highlighted">pública</span> o <span class="digitalta-highlighted">privada</span>?';
$string['teacheracademy:actions:share:language']          = 'Selecciona el <span class="digitalta-highlighted">idioma</span> de tu experiencia:';
$string['teacheracademy:actions:share:themes']            = 'Selecciona los <span class="digitalta-highlighted">temas</span> que mejor describan tu experiencia:';
$string['teacheracademy:actions:share:tags']              = 'Añade <span class="digitalta-highlighted">etiquetas</span> a tu experiencia:';

// Themes & Tags
$string['themestags:title']            = $string['concept:themestags'];
$string['themestags:header']           = $string['concept:themestags'];
$string['themestags:description']      = '<p>Explora nuestros <span class="digitalta-highlighted">temas</span> y <span class="digitalta-highlighted">etiquetas</span> para encontrar las <span class="digitalta-highlighted">experiencias</span>, <span class="digitalta-highlighted">casos</span> y <span class="digitalta-highlighted">recursos</span> compartidos por nuestra comunidad.</p>';
$string['themestags:view:description'] = '<p>Descubre las <span class="digitalta-highlighted">experiencias</span>, <span class="digitalta-highlighted">casos</span> más relevantes.y <span class="digitalta-highlighted">recursos</span> compartidos por nuestra comunidad sobre <span class="digitalta-highlighted-upper">{$a}</span>.</p>';
$string['themestags:invalidthemetag']  = 'Etiqueta o tema no válido';

// Experiences
$string['experiences:title']       = $string['concept:experiences'];
$string['experiences:header']      = $string['concept:experiences'];
$string['experiences:description'] = '<p>Explora una amplia gama de <span class="digitalta-highlighted">experiencias</span> compartidas por profesores de todo el mundo. Puedes aprender de sus ideas, reflexionar sobre sus prácticas e inspirarte con sus historias. También puedes conectar con ellos, hacerles preguntas y compartir tus propias experiencias para contribuir a la comunidad.</p>';

// Experience - Actions
$string['experience:featured']       = 'Destacados';
$string['experience:lock']           = 'Bloquear la experiencia';
$string['experience:lock:confirm']   = '¿Estás seguro de que quieres bloquear esta experiencia?';
$string['experience:unlock']         = 'Desbloquear la experiencia';
$string['experience:unlock:confirm'] = '¿Estás seguro de que quieres desbloquear esta experiencia?';
$string['experience:delete']         = 'Borrar experiencia';
$string['experience:delete:confirm'] = '¿Estás seguro de que quieres eliminar esta experiencia?';
$string['experience:delete:success'] = 'Experiencia eliminada con éxito';
$string['experience:export']         = 'Exportar la experiencia a un caso de estudio';

// Experience - Tutoring
$string['experience:tutoring:title']       = 'Tutores';
$string['experience:tutoring:description'] = 'Los tutores son una excelente forma de obtener apoyo y orientación personalizados sobre tu práctica docente. Puedes solicitar sesiones de tutoría con educadores experimentados que pueden ayudarte a reflexionar sobre tus experiencias, proporcionarte comentarios y ofrecerte valiosas perspectivas.';
$string['experience:tutoring:see_all']     = 'Ver todos los tutores';
$string['experience:tutoring:placeholder'] = 'Buscar tutores o mentores...';
$string['experience:tutoring:notutors']    = 'No hay tutores o mentores asignados a esta experiencia.';

// Experience - Reflection
$string['experience:reflection:title']                = 'Reflexiona sobre tu experiencia';
$string['experience:reflection:description']          = 'Comenzaste tu proceso de autorreflexión al describir el contexto de tu experiencia. Ahora, puedes continuar describiendo lo que hiciste, por qué lo hiciste y qué pasó cuando lo probaste. También puedes reflexionar sobre lo que has aprendido, qué impacto ha tenido y qué deberías hacer a continuación. También puedes vincular los recursos que hayas utilizado durante este proceso.';
$string['experience:reflection:edit']                 = 'Reflexionar';
$string['experience:reflection:what']                 = '¿Qué?';
$string['experience:reflection:what:description']     = 'Describe brevemente el <span class="digitalta-highlighted">contexto</span> de tu experiencia. Describe lo que ocurre en tu clase ¿Cuál es el problema? ¿Qué pensabas/sentías?';
$string['experience:reflection:so_what']              = '¿Y qué?';
$string['experience:reflection:so_what:description']  = '¿Cómo has <span class="digitalta-highlighted">obtenido más información</span> sobre tu experiencia? A través de compañeros, de la literatura, de un mentor... ¿A quién has preguntado? ¿Qué has leído?';
$string['experience:reflection:now_what']             = '¿Y ahora qué?';
$string['experience:reflection:now_what:description'] = '¿Qué has hecho, por qué lo has hecho y qué ha ocurrido cuando lo has probado? ¿Qué <span class="digitalta-highlighted">aprendiste</span>, qué impacto tuvo y qué deberías hacer a continuación?';
$string['experience:reflection:empty']                = 'Esta parte del proceso de reflexión aún no se ha llevado a cabo.';

// Experience - Resources
$string['experience:resources:link']             = 'Vincular recursos';
$string['experience:resources:link:description'] = 'Puedes vincular recursos del repositorio a tu experiencia.';
$string['experience:resources:unlink']           = 'Desvincular recurso';
$string['experience:resources:unlink:confirm']   = '¿Estás seguro de que quieres desvincular este recurso de la experiencia?';
$string['experience:resources:add_new']          = 'Añadir un nuevo recurso';
$string['experience:resources:description']      = '¿Por qué has elegido este recurso? ¿Cómo lo has utilizado? ¿Qué has aprendido?';
$string['experience:resources:empty']            = 'Aún no hay recursos vinculados esta experiencia.';
$string['experience:resources:visit']            = 'Ver recurso';

// Cases
$string['cases:title']       = $string['concept:cases'];
$string['cases:header']      = $string['concept:cases'];
$string['cases:description'] = '<p>Explora una colección de <span class="digitalta-highlighted">casos</span> compartidos por profesores de todo el mundo. Cada caso es una descripción detallada de una experiencia docente real, que incluye el contexto, el problema, las medidas adoptadas, los resultados y las reflexiones del profesor.</p>';

// Cases - Management
$string['cases:manage']                 = 'Gestionar casos';
$string['cases:manage:add']             = 'Añadir un nuevo caso';
$string['cases:manage:add:button']      = 'Añadir';
$string['cases:manage:add:placeholder'] = 'Introduce el título del caso...';
$string['cases:manage:title']           = 'Título';
$string['cases:manage:description']     = 'Descripción';
$string['cases:manage:themes']          = $string['concept:themes'];
$string['cases:manage:tags']            = $string['concept:tags'];
$string['cases:manage:language']        = $string['concept:language'];
$string['cases:manage:new']             = 'Nuevo caso';

// Case - Actions
$string['case:delete']         = 'Eliminar caso';
$string['case:delete:confirm'] = '¿Estás seguro de que quieres eliminar este caso?';
$string['case:delete:success'] = 'Caso eliminado con éxito';
$string['case:save']           = 'Guardar caso';
$string['case:save:confirm']   = '¿Estás seguro de que quieres guardar este caso?';
$string['case:save:error:editingsections'] = 'Por favor, termine de editar las secciones antes de guardar el caso.';

// Case - Sections
$string['case:section:add']            = 'Añadir sección';
$string['case:section:delete']         = 'Eliminar sección';
$string['case:section:delete:confirm'] = '¿Está seguro de que desea eliminar esta sección?';
$string['case:section:title']          = 'Título';
$string['case:section:content']        = 'Contenido';

// Resources
$string['resources:title']       = $string['concept:resources'];
$string['resources:header']      = $string['concept:resources'];
$string['resources:description'] = '<p>Descubre una amplia gama de <span class="digitalta-highlighted">recursos</span> compartidos por profesores de todo el mundo. Puedes encontrar libros, vídeos, sitios web y otros materiales didácticos que pueden ayudarte a mejorar tu práctica docente, atraer a tus alumnos e inspirar tus clases. También puedes compartir tus propios recursos para contribuir a la comunidad.</p>';

// Resources - Management
$string['resources:manage:add']                     = 'Añadir recurso';
$string['resources:manage:add:description']         = 'Puedes añadir un nuevo recurso al repositorio rellenando los campos requeridos a continuación.';
$string['resources:manage:name']                    = 'Nombre';
$string['resources:manage:name:placeholder']        = 'Introduce el nombre del recurso...';
$string['resources:manage:path']                    = 'Enlace';
$string['resources:manage:path:placeholder']        = 'Introduce el enlace al recurso...';
$string['resources:manage:description']             = 'Descripción';
$string['resources:manage:description:placeholder'] = 'Introduce una breve descripción del recurso...';
$string['resources:manage:themes']                  = $string['concept:themes'];
$string['resources:manage:tags']                    = $string['concept:tags'];
$string['resources:manage:type']                    = 'Tipo';
$string['resources:manage:language']                = $string['concept:language'];

// Resource - Actions
$string['resource:delete']         = 'Eliminar recurso';
$string['resource:delete:confirm'] = '¿Está seguro de que desea eliminar este recurso?';
$string['resource:delete:success'] = 'Recurso eliminado correctamente';

// Tutors
$string['tutors:title']       = $string['concept:tutorsmentors'];
$string['tutors:header']      = $string['concept:tutorsmentors'];
$string['tutors:description'] = '<p>Conecta con <span class="digitalta-highlighted">tutores</span> y <span class="digitalta-highlighted">mentores</span> experimentados que pueden ayudarte a reflexionar sobre tu práctica docente, proporcionarte comentarios y ofrecerte valiosas perspectivas. Puedes solicitar sesiones de tutoría, hacer preguntas y obtener apoyo personalizado para mejorar tus habilidades docentes y capacitar a tus alumnos.</p>';

// Profile
$string['profile:title']  = 'Perfil';
$string['profile:header'] = 'Perfil';

// Elements - Components
$string['component:experience'] = $string['concept:experience'];
$string['component:case']       = $string['concept:case'];
$string['component:resource']   = $string['concept:resource'];
$string['component:user']       = $string['concept:user'];

// Elements - Modifiers
$string['modifier:theme'] = $string['concept:theme'];
$string['modifier:tag']   = $string['concept:tag'];

// Elements - Themes
$string['theme:digital_technology']                         = 'Tecnología digital';
$string['theme:classroom_management']                       = 'Gestión del aula';
$string['theme:communication_and_relationship_building']    = 'Comunicación y desarrollo de relaciones';
$string['theme:diversity_and_inclusion']                    = 'Diversidad e inclusión';
$string['theme:professional_collaboration_and_development'] = 'Colaboración y desarrollo profesional';
$string['theme:school_culture']                             = 'Cultura escolar';
$string['theme:curriculum_planning_and_development']        = 'Planificación y desarrollo curricular';
$string['theme:others']                                     = 'Otros';

// Elements - Resource types
$string['resource_type:other']       = 'Otros';
$string['resource_type:book']        = 'Libro';
$string['resource_type:chart']       = 'Gráfico';
$string['resource_type:comic']       = 'Cómic';
$string['resource_type:diary']       = 'Diario';
$string['resource_type:field_notes'] = 'Notas de campo';
$string['resource_type:image']       = 'Imagen';
$string['resource_type:interview']   = 'Entrevista';
$string['resource_type:journal']     = 'Revista académica';
$string['resource_type:magazine']    = 'Revista de interés general';
$string['resource_type:map']         = 'Mapa';
$string['resource_type:music']       = 'Música';
$string['resource_type:newspaper']   = 'Periódico';
$string['resource_type:photograph']  = 'Fotografía';
$string['resource_type:podcast']     = 'Podcast';
$string['resource_type:report']      = 'Informe';
$string['resource_type:study_case']  = 'Caso de estudio';
$string['resource_type:video']       = 'Vídeo';
$string['resource_type:website']     = 'Página web';

// Elements - Resource formats
$string['resource_format:none']     = 'Ninguno';
$string['resource_format:link']     = 'Enlace';
$string['resource_format:image']    = 'Imagen';
$string['resource_format:video']    = 'Vídeo';
$string['resource_format:document'] = 'Documento';

// Elements - Section groups
$string['section_group:general']  = 'General';
$string['section_group:what']     = '¿Qué?';
$string['section_group:so_what']  = '¿Y qué?';
$string['section_group:now_what'] = '¿Y ahora qué?';

// Elements - Section types
$string['section_type:text'] = 'Texto';














// Tutor Repository - MyTutoring
$string['tutor_searchbar_placeholder'] = 'Buscar un tutor...';

// Filters
$string['filter_themes_label'] = 'Temas';
$string['filter_themes_placeholder'] = 'Seleccione un tema...';
$string['filter_tags_label'] = 'Etiquetas';
$string['filter_tags_placeholder'] = 'Seleccione una etiqueta...';
$string['filter_language_label'] = 'Idioma';
$string['filter_language_placeholder'] = 'Selecciona un idioma...';

// Tutoring
$string['tutoring:request'] = 'Solicitud de tutoría';
$string['tutoring:title'] = 'MI TUTORÍA';
$string['tutoring:back_to_chat'] = 'Volver al chat';
$string['tutoring:tutor_comments'] = 'Comentarios del tutor';
$string['tutoring:open_chats'] = 'Chats abiertos';
$string['tutoring:view_tooltip'] = 'Ver información sobre herramientas';
$string['tutoring:videocallbutton'] = 'Iniciar llamada de Google Meet';
$string['tutoring:joinvideocall'] = 'Únete a la convocatoria Google Meet';
$string['tutoring:closevideocall'] = 'Terminar llamada';
$string['tutoring:at_university'] = 'Profesor en';
