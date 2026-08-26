$(function(){
           // var data1 = [{"Email":"dog"},{"Email":"cat","Email":"fish"},{"Email":"catfish"},{"Email":"dogfish"}]; console.log(data1);
            var data = <?= $email;?>; 
                // Instantiate the Bloodhound suggestion engine
                var tags = new Bloodhound({
                    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.Email); },
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    local: $.map(data, function(list){
                       return {Email: list};
                    })
                });

                tags.initialize();

                // Set up an on-screen console for the demo
                var screenConsole = $('#console');

                // Write callback data to the screen when tags are added or removed in demo inputs
                var logCallbackDataToConsole = function(added, removed) {
                    screenConsole.append('Tag Data: ' + (this.val() || null) + ', Added: ' + added + ', Removed: ' + removed + '\n');
                };

                // Create typeahead-enabled tag inputs
                $('.tag-input').tagInput({
                	// tags separator
  					tagDataSeparator: ',',

                    allowDuplicates: false,
                    typeahead: true,
                    typeaheadOptions: {
                        highlight: true
                    },
                    typeaheadDatasetOptions: {
                        display: function(d) { return d.Email; },
                        source: tags.ttAdapter()
                    },
                    onTagDataChanged: logCallbackDataToConsole
                });

                // Create basic tag inputs with no typeahead
                $('.tag-input-basic').tagInput({
                    onTagDataChanged: logCallbackDataToConsole
                });

                $('#results a[rel="external"]').attr('target', '_blank');

            });