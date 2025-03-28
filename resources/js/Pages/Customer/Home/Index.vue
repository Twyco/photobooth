<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";
import Timeline from "@/Components/Timeline.vue";

const instructions = [
  {
    title: 'Code eingeben:',
    description: 'Auf der Startseite gibst du den Code ein, den du bei der Fotobox bekommen hast. Damit kannst du ' +
      'das dazugehörige Album ansehen.',
  },
  {
    title: 'Codes speichern:',
    description: 'Wenn du nur mal reinschauen willst, geht das auch ohne Anmeldung. Aber: Wenn du dir ein Konto ' +
      'anlegst und dich einloggst, werden alle Codes, die du hier eingibst, automatisch in deinem Konto gespeichert. ' +
      'Das heißt, du musst die nicht jedes Mal neu eingeben.',
  },
  {
    title: 'Alle Alben im Überblick:',
    description: 'Wenn du angemeldet bist, kannst du unter Fotoalben alle Alben sehen, dessen Codes in deinem ' +
      'Konto gespeichert sind.',
  },
]

</script>

<template>
  <AppLayout>
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <TitleSeparator title="Wie funktioniert es?"/>
        <div class="container-small mb-6">
          <Timeline :events="instructions"/>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
