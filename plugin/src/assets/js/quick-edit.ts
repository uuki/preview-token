/**
 * Quick Edit entry.
 * Mounts DrptTokenPanel inside the #edit-{postId} rows via MutationObserver.
 * WordPress deps: wp-element, inline-edit-post
 */

import { DrptTokenPanel } from './token-panel'
import { NativeBtn, NativeSelect } from './native-components'
import { CLASS_QUICK_EDIT_ROOT, LOG_PREFIX } from './constants'

if (typeof drptPreviewData === 'undefined') {
  throw new Error(`${LOG_PREFIX} drptPreviewData is not defined`)
}

const { createElement: el } = wp.element

// ── renderToContainer ─────────────────────────────────────────────────────────

interface DrptContainer extends HTMLElement {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  _drptRoot?: { render: (children: any) => void; unmount: () => void }
}

const renderToContainer = (container: DrptContainer, postId: number): void => {
  const panel = el(DrptTokenPanel, { postId, Btn: NativeBtn, SelectInput: NativeSelect })
  if (wp.element.createRoot) {
    if (!container._drptRoot) container._drptRoot = wp.element.createRoot(container)
    container._drptRoot!.render(panel)
  } else {
    wp.element.render(panel, container)
  }
}

// ── Mount / unmount ───────────────────────────────────────────────────────────

const getQuickEditCol = (row: HTMLElement): HTMLElement | null =>
  row.querySelector('.inline-edit-col-left .inline-edit-col') ??
  row.querySelector('.inline-edit-col')

const mountPanel = (row: HTMLElement, postId: number): void => {
  const col = getQuickEditCol(row)
  if (!col || !postId) return

  let container = col.querySelector<DrptContainer>(`.${CLASS_QUICK_EDIT_ROOT}`)
  if (!container) {
    container = document.createElement('div') as DrptContainer
    container.className = CLASS_QUICK_EDIT_ROOT
    container.style.cssText = 'border-top:1px solid #ddd;margin-top:8px;padding-top:8px'
    col.appendChild(container)
  }
  renderToContainer(container, postId)
}

const unmountRow = (row: HTMLElement): void => {
  const container = row.querySelector<DrptContainer>(`.${CLASS_QUICK_EDIT_ROOT}`)
  if (!container) return
  container._drptRoot?.unmount()
  container._drptRoot = undefined
  container.remove()
}

// ── MutationObserver ──────────────────────────────────────────────────────────
// WordPress 6.x creates a new <tr id="edit-{postId}"> for each Quick Edit open
// instead of toggling #inline-edit. Observe #the-list for childList changes.

const observeQuickEdit = (): void => {
  const list = document.getElementById('the-list')
  if (!list) return

  new MutationObserver(mutations => {
    for (const mutation of mutations) {
      for (const node of Array.from(mutation.addedNodes)) {
        if (!(node instanceof HTMLElement)) continue
        const match = /^edit-(\d+)$/.exec(node.id ?? '')
        if (match) mountPanel(node, parseInt(match[1]!, 10))
      }
      for (const node of Array.from(mutation.removedNodes)) {
        if (!(node instanceof HTMLElement)) continue
        if (/^edit-\d+$/.test(node.id ?? '')) unmountRow(node)
      }
    }
  }).observe(list, { childList: true })
}

if (document.readyState !== 'loading') {
  observeQuickEdit()
} else {
  document.addEventListener('DOMContentLoaded', observeQuickEdit)
}
