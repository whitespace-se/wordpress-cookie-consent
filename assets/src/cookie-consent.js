import "sendbeacon-polyfill";
import { init, getAnswer, ALLOW, DENY } from "@whitespace/cookie-consent";
import "@whitespace/cookie-consent/dist/cookie-consent.css";

const {
  trackingUrl,
  trackingActions,
  ...options
} = window.whitespaceCookieConsentSettings;

init({
  ...options,
  onAnswer(answer) {
    let data = new FormData();
    data.append("action", trackingActions.answer);
    data.append("answer", answer);
    navigator.sendBeacon(trackingUrl, data);
  },
});

window.WHITESPACE_COOKIE_CONSENT_ALLOW = ALLOW;
window.WHITESPACE_COOKIE_CONSENT_DENY = DENY;

window.getWhitespaceCookieConsentAnswer = getAnswer;
