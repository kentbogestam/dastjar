var mediaProperty = [];

var chunkingEndPointURL = document.location.origin + '/reelcircuit/public/media/post-chunks';
var mediaUploadEndPointURL = document.location.origin + '/reelcircuit/public/media/upload-media';
var mediaDeleteEndPointURL = document.location.origin +'/reelcircuit/public/media/destroy-media';

var allowedDocument = ['jpeg', 'jpg', 'gif', 'png'];

var fileObject = {};

var galleryUploader = new qq.FineUploader({
    debug: true,
    multiple: true,
    element: document.getElementById('fine-uploader'),
    request: {
        endpoint: mediaUploadEndPointURL,
        method: "POST"
    },
    deleteFile: {
        enabled: true,
        forceConfirm: true,
        endpoint: mediaDeleteEndPointURL
    },
    chunking: {
        enabled: true,
        concurrent: {
            enabled: true
        },
        success: {
            endpoint: chunkingEndPointURL
        }
    },
    resume: {
        enabled: true
    },
    validation: {
        allowedExtensions: allowedDocument
    },
    callbacks:{
        onComplete:function(id,name,responseJSON)
        {
            fileObject[responseJSON['uuid']] = responseJSON['fileName'];
        }
    }
});