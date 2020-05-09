<template>
    <div style="display: contents">
        <tr>
            <th scope="row">
                <span class="badge badge-light"
                      data-placement="left"
                      data-toggle="tooltip"
                      title="Score">{{ concept.score }}</span>
                <span class="badge badge-warning"
                      data-placement="left"
                      data-toggle="tooltip"
                      title="Référentiel officiel"
                      v-if="concept.standard_concept">s</span>
            </th>
            <td>{{ concept.concept_code }}</td>
            <td class="concept-name">{{ concept.concept_name }}</td>
            <td>{{ concept.start_date | moment('DD/MM/YYYY') }}</td>
            <td>{{ concept.end_date | moment('DD/MM/YYYY') }}</td>
            <td @click="display"><p :class="hasMetadata">{{ this.show ? 'Masquer': 'Afficher' }}</p></td>
        </tr>
        <tr v-show="show">
            <td class="no-padding" colspan="6" style="width: 25%">
                <pre><code class="json">{{ concept.metadata }}</code></pre>
            </td>
        </tr>
    </div>
</template>

<script>
    var d = true
    export default {
        name: 'ReferentialItem',
        props: ['concept'],
        data: () => {
            return {
                show: false
            }
        },
        created: function () {
            this.$nextTick(function () {
                // Not too efficient but do the job
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            })
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

    td.concept-name {
        width: 53%;
    }

    pre {
        white-space: pre-wrap; /* Since CSS 2.1 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        word-wrap: break-word;
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
