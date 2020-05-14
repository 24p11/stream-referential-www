<template>
    <input :metadata-dictionary-id="metadataDictionaryId"
           :value="value"
           @input="onInput"
           class="form-control form-control-sm"
           type="text"
           v-on:blur="this.save"/>
</template>

<script>
    import debounce from "lodash.debounce";

    const axios = require("axios");
    export default {
        props: ["name", "value", "metadataDictionaryId"],
        name: "AutoSaveInput",
        data() {
            return {
                inputValue: this.value
            }
        },
        created() {
            this.saveAction = debounce(this.save, 1500)
        },
        methods: {
            save() {
                let metadataDictionaryEntry = {}
                metadataDictionaryEntry[this.name] = this.inputValue
                axios
                    .put(`${baseApiUrl}/${this.metadataDictionaryId}`, metadataDictionaryEntry)
            },
            onInput(event) {
                this.inputValue = event.target.value;
                this.saveAction()
            }
        }
    }
</script>

<style scoped>

</style>
