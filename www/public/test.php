<link rel="stylesheet" type="text/css" href="Resources/styles.css?<?= rand() ?>">

<div class="container" style="margin: 50px 50px">
    <button class="btn btn-danger-outline">Inscription</button>
    <button class="btn btn-small btn-secondary">Inscription</button>
</div>

<div class="container">
    <div class="form-group">
        <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleSelect1" class="form-label mt-4">Example select</label>
        <select class="form-select" id="exampleSelect1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>

</div>

<div class="form-group">
    <select multiple="" class="form-input" id="exampleSelect2">
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
    </select>
</div>

<textarea class="form-input" id="exampleTextarea" rows="3"></textarea>

<div class="form-group">
    <label for="formFile" class="form-label mt-4">Default file input example</label>
    <input class="form-input" type="file" id="formFile">
</div>

<div class="form-group">
    <fieldset disabled="">
        <label class="form-label" for="disabledInput">Disabled input</label>
        <input class="form-input" id="disabledInput" type="text" placeholder="Disabled input here..." disabled="">
    </fieldset>
</div>

<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" data-com.bitwarden.browser.user-edited="yes">
    <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
</div>

<div class="form-check">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1" checked="" data-com.bitwarden.browser.user-edited="yes">
        Option one is this and that—be sure to include why it's great
    </label>
</div>


<div class="form-check">
    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
        Default checkbox
    </label>
</div>