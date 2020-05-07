<template>
    <div style="display: contents">
        <tr>
            <th scope="row">{{concept.id}}</th>
            <td>{{concept.concept_code}}</td>
            <td>{{concept.concept_name}}</td>
            <td>{{concept.start_date}}</td>
            <td>{{concept.end_date}}</td>
            <td @click="display"><p :class="hasMetadata">Afficher</p></td>
        </tr>
        <tr v-show="show">
            <td class="no-padding" colspan="6">
                <pre><code class="json">{{concept.metadata}}</code></pre>
            </td>
        </tr>
    </div>
</template>

<script>
    export default {
        name: 'ReferentialItem',
        props: ['concept'],
        data: () => {
            return {
                show: false
            }
        },
        methods: {
            display() {
                if (this.concept.metadata.length) {
                    this.show = !this.show
                }
            }
        },
        computed: {
            hasMetadata: function () {
                return this.concept.metadata.length
                    ? 'text-primary'
                    : 'text-secondary'
            }
        }
    }
</script>

<style>
    td.no-padding {
        padding: 0;
    }

    p.text-primary {
        cursor: pointer;
    }

    p.text-secondary {
        text-decoration: line-through;
    }

    .json {
        background-color: #fdfdfd;
    }
</style>
