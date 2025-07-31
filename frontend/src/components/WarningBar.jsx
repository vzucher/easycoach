export const WarningBar = () => {
  return (
    <div className="mb-8 card">
      <p className="leading-relaxed text-gray-700">
        This page intentionally breaks all best practices so you have something
        to refactor. It fetches the entire <strong>players</strong> table on
        every render, performs expensive computations on the client, repeats
        JSX blocks, and abuses inline styles. Feel free to cringe. 🤢
      </p>
    </div>
  )
}