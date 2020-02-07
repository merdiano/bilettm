{!! HTML::script('vendor/simplemde/dist/simplemde.min.js') !!}
{!! HTML::style('vendor/simplemde/dist/simplemde.min.css') !!}
{!!HTML::style('vendor/icon-awesome/css/font-awesome.min.css')!!}
<script>
    $(function() {
        // try {
        //     $(".geocomplete").geocomplete({
        //             details: "form.gf",
        //             types: ["geocode", "establishment"]
        //         }).bind("geocode:result", function(event, result) {
        //             console.log(result);
        //     }, 1000);
        //
        // } catch (e) {
        //     console.log(e);
        // }

        $('.editable').each(function() {
            var simplemde = new SimpleMDE({
                element: this,
                spellChecker: false,
                status: false
            });
            simplemde.render();
        })

        $("#DatePicker").remove();
        var $div = $("<div>", {id: "DatePicker"});
        $("body").append($div);
        $div.DateTimePicker({
            dateTimeFormat: Attendize.DateTimeFormat,
            dateSeparator: Attendize.DateSeparator
        });
        var parent = $("#categories"). children("option:selected"). val();
        filterSub(parent);

        $("#categories").on('change', function() {
            // $city.not(this).get(0).selectedIndex = this.selectedIndex;
            filterSub($(this).val());
            //$('#subCategories option')[0].selectedIndex = 1;
            $("select#subCategories").prop('selectedIndex', 0);
        });

        function filterSub(parent) {
            $('#subCategories option').hide(); // and show them
            $('#subCategories option[parent="'+parent+'"]').show()
        }
    });
</script>
<style>
    .editor-toolbar {
        border-radius: 0 !important;
    }
    .CodeMirror, .CodeMirror-scroll {
        min-height: 100px !important;
    }

    .create_organiser, .address-manual {
        padding: 10px;
        border: 1px solid #ddd;
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #FAFAFA;
    }

    .in-form-link {
        display: block; padding: 5px;margin-bottom: 5px;padding-left: 0;
    }
</style>
