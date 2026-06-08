/**
 * Classic Editor meta box entry.
 * Mounts DrptTokenPanel into the container injected by Settings::render_classic_meta_box().
 * WordPress deps: wp-element
 */

import { DrptTokenPanel } from './token-panel'
import { NativeBtn, NativeSelect } from './native-components'
import { ELEMENT_CLASSIC_ROOT, LOG_PREFIX } from './constants'

if (typeof drptPreviewData === 'undefined') {
  throw new Error(`${LOG_PREFIX} drptPreviewData is not defined`)
}

const { createElement: el } = wp.element

interface DrptContainer extends HTMLElement {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  _drptRoot?: { render: (children: any) => void; unmount: () => void }
}

const initClassicMetaBox = (): void => {
  const root = document.getElementById(ELEMENT_CLASSIC_ROOT) as DrptContainer | null
  if (!root) return

  const postId = parseInt(root.dataset['postId'] ?? '0', 10)
  if (!postId) return

  const panel = el(DrptTokenPanel, { postId, Btn: NativeBtn, SelectInput: NativeSelect })

  if (wp.element.createRoot) {
    if (!root._drptRoot) root._drptRoot = wp.element.createRoot(root)
    root._drptRoot!.render(panel)
  } else {
    wp.element.render(panel, root)
  }
}

if (document.readyState !== 'loading') {
  initClassicMetaBox()
} else {
  document.addEventListener('DOMContentLoaded', initClassicMetaBox)
}
