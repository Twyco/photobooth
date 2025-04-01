<script setup lang="ts">
import {UserAlbum} from "@/types/album-interface";

defineProps({
  albums: {type: Array<UserAlbum>, required: true},
});

</script>

<template>
  <p>
    //TODO GRID
  </p>
  <p>
    Change List Style to see your Albums
  </p>
</template>
