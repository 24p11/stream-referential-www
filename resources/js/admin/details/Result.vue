<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Identifiant</th>
            <th scope="col">Label</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
            <th scope="col">Metadata</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="concept in concepts">
            <ReferentialItem :concept="concept"/>
        </template>
        </tbody>
    </table>
</template>

<script>
    import ReferentialItem from "./ReferentialItem";

    export default {
        props: ['concepts'],
        components: {
            ReferentialItem
        }
    }
</script>


