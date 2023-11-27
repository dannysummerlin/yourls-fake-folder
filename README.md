# yourls-fake-folder
A Yourls plugin that allows you to fake having named links in folders (ie https://sh.ort/help/git where "help" is not a real folder) by automatically converting forward slashes (/) into underscores (_). To make use of this you must create links with underscores and then share the link with slashes, for example the Short URL **data_capture_form** would be matched to by public URLs like:

- https://sh.ort/data/capture/form
- https://sh.ort/data/capture_form
- https://sh.ort/data_capture_form

since everything after the base URL (https://sh.ort/) has its slashes converted to underscores.
