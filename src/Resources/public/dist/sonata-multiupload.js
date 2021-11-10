/*! For license information please see sonata-multiupload.js.LICENSE.txt */
(() => {
  const e = {
    193: (e, t, n) => {
      let i, s, o

      !(function (r) {
        'use strict'; s = [n(311)], i = function (e) {
          const t = 'dmUploader'; const n = { PENDING: 0, UPLOADING: 1, COMPLETED: 2, FAILED: 3, CANCELLED: 4 }; const i = { auto: !0, queue: !0, dnd: !0, hookDocument: !0, multiple: !0, url: document.URL, method: 'POST', extraData: {}, headers: {}, dataType: null, fieldName: 'file', maxFileSize: 0, allowedTypes: '*', extFilter: null, onInit: function () {}, onComplete: function () {}, onFallbackMode: function () {}, onNewFile: function () {}, onBeforeUpload: function () {}, onUploadProgress: function () {}, onUploadSuccess: function () {}, onUploadCanceled: function () {}, onUploadError: function () {}, onUploadComplete: function () {}, onFileTypeError: function () {}, onFileSizeError: function () {}, onFileExtError: function () {}, onDragEnter: function () {}, onDragLeave: function () {}, onDocumentDragEnter: function () {}, onDocumentDragLeave: function () {} }; const s = function (e, t) { this.data = e, this.widget = t, this.jqXHR = null, this.status = n.PENDING, this.id = Math.random().toString(36).substr(2) }

          s.prototype.upload = function () {
            const t = this

            if (!t.canUpload()) return t.widget.queueRunning && t.status !== n.UPLOADING && t.widget.processQueue(), !1

            const i = new FormData()

            i.append(t.widget.settings.fieldName, t.data)

            let s = t.widget.settings.extraData

            return typeof s === 'function' && (s = s.call(t.widget.element, t.id)), e.each(s, function (e, t) { i.append(e, t) }), t.status = n.UPLOADING, t.widget.activeFiles++, t.widget.settings.onBeforeUpload.call(t.widget.element, t.id), t.jqXHR = e.ajax({ url: t.widget.settings.url, type: t.widget.settings.method, dataType: t.widget.settings.dataType, data: i, headers: t.widget.settings.headers, cache: !1, contentType: !1, processData: !1, forceSync: !1, xhr: function () { return t.getXhr() }, success: function (e) { t.onSuccess(e) }, error: function (e, n, i) { t.onError(e, n, i) }, complete: function () { t.onComplete() } }), !0
          }, s.prototype.onSuccess = function (e) { this.status = n.COMPLETED, this.widget.settings.onUploadSuccess.call(this.widget.element, this.id, e) }, s.prototype.onError = function (e, t, i) { this.status !== n.CANCELLED && (this.status = n.FAILED, this.widget.settings.onUploadError.call(this.widget.element, this.id, e, t, i)) }, s.prototype.onComplete = function () { this.widget.activeFiles--, this.status !== n.CANCELLED && this.widget.settings.onUploadComplete.call(this.widget.element, this.id), this.widget.queueRunning ? this.widget.processQueue() : this.widget.settings.queue && this.widget.activeFiles === 0 && this.widget.settings.onComplete.call(this.element) }, s.prototype.getXhr = function () {
            const t = this; const n = e.ajaxSettings.xhr()

            return n.upload && n.upload.addEventListener('progress', function (e) {
              let n = 0; const i = e.loaded || e.position; const s = e.total || e.totalSize

              e.lengthComputable && (n = Math.ceil(i / s * 100)), t.widget.settings.onUploadProgress.call(t.widget.element, t.id, n)
            }, !1), n
          }, s.prototype.cancel = function (e) {
            e = void 0 !== e && e

            const t = this.status

            return !!(t === n.UPLOADING || e && t === n.PENDING) && (this.status = n.CANCELLED, this.widget.settings.onUploadCanceled.call(this.widget.element, this.id), t === n.UPLOADING && this.jqXHR.abort(), !0)
          }, s.prototype.canUpload = function () { return this.status === n.PENDING || this.status === n.FAILED }

          const o = function (t, n) { return this.element = e(t), this.settings = e.extend({}, i, n), this.checkSupport() ? (this.init(), this) : (e.error('Browser not supported by jQuery.dmUploader'), this.settings.onFallbackMode.call(this.element), !1) }

          o.prototype.checkSupport = function () { return void 0 !== window.FormData && (!new RegExp('/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle/(1.0|2.0|2.5|3.0))/').test(window.navigator.userAgent) && !e('<input type="file" />').prop('disabled')) }, o.prototype.init = function () {
            const n = this

            this.queue = [], this.queuePos = -1, this.queueRunning = !1, this.activeFiles = 0, this.draggingOver = 0, this.draggingOverDoc = 0

            const i = n.element.is('input[type=file]') ? n.element : n.element.find('input[type=file]')

            return i.length > 0 && (i.prop('multiple', this.settings.multiple), i.on('change.' + t, function (t) {
              const i = t.target && t.target.files

              i && i.length && (n.addFiles(i), e(this).val(''))
            })), this.settings.dnd && this.initDnD(), i.length !== 0 || this.settings.dnd ? (this.settings.onInit.call(this.element), this) : (e.error('Markup error found by jQuery.dmUploader'), null)
          }, o.prototype.initDnD = function () {
            const n = this

            n.element.on('drop.' + t, function (e) {
              e.preventDefault(), n.draggingOver > 0 && (n.draggingOver = 0, n.settings.onDragLeave.call(n.element))

              const t = e.originalEvent && e.originalEvent.dataTransfer

              if (t && t.files && t.files.length) {
                let i = []

                n.settings.multiple ? i = t.files : i.push(t.files[0]), n.addFiles(i)
              }
            }), n.element.on('dragenter.' + t, function (e) { e.preventDefault(), n.draggingOver === 0 && n.settings.onDragEnter.call(n.element), n.draggingOver++ }), n.element.on('dragleave.' + t, function (e) { e.preventDefault(), n.draggingOver--, n.draggingOver === 0 && n.settings.onDragLeave.call(n.element) }), n.settings.hookDocument && (e(document).off('drop.' + t).on('drop.' + t, function (e) { e.preventDefault(), n.draggingOverDoc > 0 && (n.draggingOverDoc = 0, n.settings.onDocumentDragLeave.call(n.element)) }), e(document).off('dragenter.' + t).on('dragenter.' + t, function (e) { e.preventDefault(), n.draggingOverDoc === 0 && n.settings.onDocumentDragEnter.call(n.element), n.draggingOverDoc++ }), e(document).off('dragleave.' + t).on('dragleave.' + t, function (e) { e.preventDefault(), n.draggingOverDoc--, n.draggingOverDoc === 0 && n.settings.onDocumentDragLeave.call(n.element) }), e(document).off('dragover.' + t).on('dragover.' + t, function (e) { e.preventDefault() }))
          }, o.prototype.releaseEvents = function () { this.element.off('.' + t), this.element.find('input[type=file]').off('.' + t), this.settings.hookDocument && e(document).off('.' + t) }, o.prototype.validateFile = function (t) {
            if (this.settings.maxFileSize > 0 && t.size > this.settings.maxFileSize) return this.settings.onFileSizeError.call(this.element, t), !1

            if (this.settings.allowedTypes !== '*' && !t.type.match(this.settings.allowedTypes)) return this.settings.onFileTypeError.call(this.element, t), !1

            if (this.settings.extFilter !== null) {
              const n = t.name.toLowerCase().split('.').pop()

              if (e.inArray(n, this.settings.extFilter) < 0) return this.settings.onFileExtError.call(this.element, t), !1
            }

            return new s(t, this)
          }, o.prototype.addFiles = function (e) {
            for (var t = 0, n = 0; n < e.length; n++) {
              const i = this.validateFile(e[n])

              if (i)!1 !== this.settings.onNewFile.call(this.element, i.id, i.data) && (this.settings.auto && !this.settings.queue && i.upload(), this.queue.push(i), t++)
            }

            return t === 0 || this.settings.auto && this.settings.queue && !this.queueRunning && this.processQueue(), this
          }, o.prototype.processQueue = function () { return this.queuePos++, this.queuePos >= this.queue.length ? (this.activeFiles === 0 && this.settings.onComplete.call(this.element), this.queuePos = this.queue.length - 1, this.queueRunning = !1, !1) : (this.queueRunning = !0, this.queue[this.queuePos].upload()) }, o.prototype.restartQueue = function () { this.queuePos = -1, this.queueRunning = !1, this.processQueue() }, o.prototype.findById = function (e) {
            for (var t = !1, n = 0; n < this.queue.length; n++) {
              if (this.queue[n].id === e) {
                t = this.queue[n]

                break
              }
            }

            return t
          }, o.prototype.cancelAll = function () {
            const e = this.queueRunning

            this.queueRunning = !1

            for (let t = 0; t < this.queue.length; t++) this.queue[t].cancel(); e && this.settings.onComplete.call(this.element)
          }, o.prototype.startAll = function () { if (this.settings.queue) this.restartQueue(); else for (let e = 0; e < this.queue.length; e++) this.queue[e].upload() }, o.prototype.methods = {
            start: function (t) {
              if (this.queueRunning) return !1

              let i = !1

              return void 0 === t || (i = this.findById(t)) ? i ? (i.status === n.CANCELLED && (i.status = n.PENDING), i.upload()) : (this.startAll(), !0) : (e.error('File not found in jQuery.dmUploader'), !1)
            },
            cancel: function (t) {
              let n = !1

              return void 0 === t || (n = this.findById(t)) ? n ? n.cancel(!0) : (this.cancelAll(), !0) : (e.error('File not found in jQuery.dmUploader'), !1)
            },
            reset: function () { return this.cancelAll(), this.queue = [], this.queuePos = -1, this.activeFiles = 0, !0 },
            destroy: function () { this.cancelAll(), this.releaseEvents(), this.element.removeData(t) },
          }, e.fn.dmUploader = function (n) {
            const i = arguments

            if (typeof n !== 'string') return this.each(function () { e.data(this, t) || e.data(this, t, new o(this, n)) }); this.each(function () {
              const s = e.data(this, t)

              s instanceof o ? typeof s.methods[n] === 'function' ? s.methods[n].apply(s, Array.prototype.slice.call(i, 1)) : e.error('Method ' + n + ' does not exist in jQuery.dmUploader') : e.error('Unknown plugin data found by jQuery.dmUploader')
            })
          }
        }, void 0 === (o = typeof i === 'function' ? i.apply(t, s) : i) || (e.exports = o)
      }())
    },
    311: e => { 'use strict'; e.exports = jQuery },
  }; const t = {}

  function n (i) {
    const s = t[i]

    if (void 0 !== s) return s.exports

    const o = t[i] = { exports: {} }

    return e[i](o, o.exports, n), o.exports
  }n.n = e => {
    const t = e && e.__esModule ? () => e.default : () => e

    return n.d(t, { a: t }), t
  }, n.d = (e, t) => { for (const i in t)n.o(t, i) && !n.o(e, i) && Object.defineProperty(e, i, { enumerable: !0, get: t[i] }) }, n.o = (e, t) => Object.prototype.hasOwnProperty.call(e, t), (() => { 'use strict'; n(193) })()
})()
