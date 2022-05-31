@if (!$hideTitle)
    @typography([
        'element' => 'h4',
        'variant' => 'h2',
        'classList' => ['module-title']
    ])
    {{ $postTitle }}
    @endtypography
@endif

@include($template ? $template . '-template' : 'button-template')

@if($enableRekAI)
    <script>
        window.addEventListener("rekai.load", function() {
          function createTemplateItem(data, template) {
            let view = '';
            switch(template) {
              case "card":
                view = '<?php echo modularity_recommend_render_blade_view("partials.card", ["heading" => "{MOD_RECOMMEND_TITLE}", "content" => "{MOD_RECOMMEND_CONTENT}", "href" => "{MOD_RECOMMEND_HREF}", "gridClass" => $gridClass]); ?>';
                break;
              case "button":
              default:
                view = '<?php echo modularity_recommend_render_blade_view("partials.button", ["href"=> "{MOD_RECOMMEND_HREF}", "text" => "{MOD_RECOMMEND_TITLE}", "type" => "dynamic"]); ?> ';
            }

            view = view.replace("{MOD_RECOMMEND_HREF}", data.url ?? '');
            view = view.replace("{MOD_RECOMMEND_TITLE}", data.title ?? '');
            view = view.replace("{MOD_RECOMMEND_CONTENT}", data.ingress ?? '');

            return view;
          }

            function renderHtml(data) {
                let rekAiInputString = '';
                let targetId = document.getElementById("{{$recommendUid}}");

                if(targetId) {
                    //Remove the preloader
                    let preloaderItems = targetId.querySelectorAll(".rek-ai-preload-remove");
                    if(preloaderItems) {
                        preloaderItems.forEach(function(item) {
                            item.remove();
                        });
                    }

                    //Append content
                    for(var i = 0; i < data.predictions.length; i++) {
                        rekAiInputString = createTemplateItem(data.predictions[i], "{{$template}}");
                        targetId.insertAdjacentHTML("beforeend", rekAiInputString);
                    }
                }
            }

          var advancedOptions = {}
          var rekaiOptions = {}
          try {
            advancedOptions = JSON.parse({!! $advancedOptions !!})
            rekaiOptions = JSON.parse(JSON.stringify({!! $rekaiOptions !!}))
          } catch (error) {
            console.error(error)
          }

          var options = {
            overwrite: {
              addcontent: true,
              nrofhits: {{ $rekaiNumberOfRecommendation }},
              ...rekaiOptions,
              ...advancedOptions
            },
          }

          window.__rekai.predict(options, renderHtml);
        });
    </script>
@endif
