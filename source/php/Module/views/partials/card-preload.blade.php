<div class="o-grid">
  @for ($i = 0; $i < $rekaiNumberOfRecommendation; $i++)
      <div class="c-card">
          <div class="c-card__body">
          @typography([
            'element' => 'h4',
            'classList' => ['u-preloader'],
            'attributeList' => [
              'style' => 'width: ' .rand(30, 90). '%; border-radius: 10px;'
            ]
          ])
          <br>
          @endtypography
          @typography([
            'element' => 'p',
            'classList' => ['u-preloader'],
            'attributeList' => [
              'style' => 'border-radius: 10px;'
            ]
          ])
          <br><br>
          @endtypography
          </div>
      </div>
  @endfor
</div>
